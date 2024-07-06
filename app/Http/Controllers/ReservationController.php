<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Commands\Reservation\CancelReservationCommand;
use App\Commands\Reservation\CancelReservationHandler;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Reservation;
use App\Queries\Reservation\FindReservationByUserHandler;
use App\Queries\Reservation\FindReservationByUserQuery;
use App\Queries\Reservation\FindReservationQuery;
use App\Queries\Reservation\FindReservationsHandler;
use App\Repositories\Enum\ReservationOrderByEnum;
use App\Services\PaginateService;
use App\Transformers\Controllers\ReservationsTransformer;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        return Inertia::render('Reservations/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        //
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
