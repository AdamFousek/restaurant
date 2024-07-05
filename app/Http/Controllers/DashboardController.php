<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Queries\Reservation\FindReservationByUserHandler;
use App\Queries\Reservation\FindReservationByUserQuery;
use App\Transformers\Controllers\ReservationsTransformer;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        private readonly FindReservationByUserHandler $findReservationByUserIdHandler,
        private readonly ReservationsTransformer $reservationsTransformer,
    ) {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(): Response
    {
        $user = $this->getUser();

        $reservation = $this->findReservationByUserIdHandler->handle(new FindReservationByUserQuery(
            user: $user,
            dateFrom: new Carbon(),
        ));

        $reservation = $reservation !== null ? $this->reservationsTransformer->transformOne($reservation) : null;

        return Inertia::render('Dashboard', [
            'reservation' => $reservation
        ]);
    }
}
