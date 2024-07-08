<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Commands\Reservation\CancelReservationCommand;
use App\Commands\Reservation\CancelReservationHandler;
use App\Commands\Reservation\UpsertReservationCommand;
use App\Commands\Reservation\UpsertReservationHandler;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use App\Queries\Reservation\FindReservationQuery;
use App\Queries\Reservation\FindReservationsHandler;
use App\Queries\Reservation\GetTableReservationByDateHandler;
use App\Queries\Reservation\GetTableReservationByDateQuery;
use App\Repositories\Enum\ReservationOrderByEnum;
use App\Services\PaginateService;
use App\Services\ReservationService;
use App\Transformers\Controllers\ReservationsTransformer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class ReservationController extends Controller
{
    private const int RESERVATION_LIMIT = 10;

    public function __construct(
        private readonly FindReservationsHandler $findReservationsHandler,
        private readonly ReservationsTransformer $reservationsTransformer,
        private readonly PaginateService $paginateService,
        private readonly CancelReservationHandler $cancelReservationHandler,
        private readonly ReservationService $reservationService,
        private readonly UpsertReservationHandler $upsertReservationHandler,
        private readonly GetTableReservationByDateHandler $getTableReservationByDateHandler,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $page = (int)$request->get('page', 1);

        $reservations = $this->findReservationsHandler->handle(new FindReservationQuery(
            user: $user,
            pagination: self::RESERVATION_LIMIT,
            orderBy: ReservationOrderByEnum::ORDER_BY_RESERVATION_DATETIME,
        ));

        return Inertia::render('Reservations/Index',
            [
                'reservations' => $this->reservationsTransformer->transform(collect($reservations->items())),
                'paginate' => [
                    'links' => $this->paginateService->resolveLinks($reservations),
                    'page' => $page,
                    'total' => $reservations->total(),
                    'limit' => self::RESERVATION_LIMIT
                ],
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $limitDays = config('restaurant.max_days_reservation', 30);
        $tomorrow = (new Carbon())->addDay();
        $limit = (new Carbon())->addDays($limitDays);
        $availableDays = $this->reservationService->resolveDays($tomorrow, $limit);

        $minHour = config('restaurant.min_hour', 11);
        $maxHour = config('restaurant.max_hour', 20);

        return Inertia::render('Reservations/Create', [
            'availableDays' => $availableDays,
            'minHour' => $minHour,
            'maxHour' => $maxHour,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        try {
            $date = Carbon::createFromFormat('d.m.Y H:i', $data['date']) ?? Carbon::now();
            $maxTables = config('restaurant.max_tables', 30);
            $tablesOccupied = $this->getTableReservationByDateHandler->handle(new GetTableReservationByDateQuery(
                $date
            ));

            // In case there will be several reservations at the same time
            $availableTables = max($maxTables - $tablesOccupied, 0);
            $reservationTables = (int)$data['numberOfTables'];
            if ($availableTables < $reservationTables) {
                $this->withMessage(self::ALERT_ERROR, 'Not enough tables available for this date');

                return redirect()->back();
            }

            $this->upsertReservationHandler->handle(new UpsertReservationCommand(
                user: $this->getUser(),
                date: $date,
                tables: $reservationTables,
                specialRequest: $data['specialRequest'] ?? '',
            ));

            $this->withMessage(self::ALERT_SUCCESS, 'Reservation was created');
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['exception' => $e]);

            $this->withMessage(self::ALERT_ERROR, 'Something went wrong! Try again later.');

            return redirect()->back();
        }

        return redirect()->route('reservations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation): RedirectResponse
    {
        Gate::authorize('delete', $reservation);

        try {
            $this->cancelReservationHandler->handle(new CancelReservationCommand(
                $this->getUser(),
                $reservation,
            ));


            $this->withMessage(self::ALERT_SUCCESS, 'Reservation was canceled');
        } catch (Throwable $e) {
            Log::error($e->getMessage(), ['exception' => $e]);

            $this->withMessage(self::ALERT_ERROR, 'Something went wrong! Try again later.');

            return redirect()->back();
        }

        return to_route('reservations.index');
    }
}
