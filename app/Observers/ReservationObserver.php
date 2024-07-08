<?php

namespace App\Observers;

use App\Mail\ReservationCreated;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Support\Facades\Mail;

readonly class ReservationObserver
{
    public function __construct(
        private ReservationService $reservationService,
    ) {
    }

    /**
     * Handle the Reservation "created" event.
     */
    public function created(Reservation $reservation): void
    {
        $date = $reservation->reservation_datetime;
        $this->reservationService->pruneCache($date);

        // Also send email to restaurant
        Mail::to(config('restaurant.notify_email'))->send(new ReservationCreated($reservation));
    }

    /**
     * Handle the Reservation "deleted" event.
     */
    public function deleted(Reservation $reservation): void
    {
        $date = $reservation->reservation_datetime;
        $this->reservationService->pruneCache($date);
    }
}
