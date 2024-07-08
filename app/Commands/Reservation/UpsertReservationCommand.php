<?php

declare(strict_types=1);


namespace App\Commands\Reservation;

use App\Models\User;
use Carbon\Carbon;

readonly class UpsertReservationCommand
{
    public function __construct(
        public User $user,
        public Carbon $date,
        public int $tables,
        public string $specialRequest = '',
    ) {
    }
}
