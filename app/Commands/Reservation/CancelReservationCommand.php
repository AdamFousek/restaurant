<?php

declare(strict_types=1);


namespace App\Commands\Reservation;

use App\Models\Reservation;
use App\Models\User;

readonly class CancelReservationCommand
{
    public function __construct(
        public User $user,
        public Reservation $reservation,
    ) {
    }
}
