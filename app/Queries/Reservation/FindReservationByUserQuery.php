<?php

declare(strict_types=1);


namespace App\Queries\Reservation;

use App\Models\User;
use Illuminate\Support\Carbon;

readonly class FindReservationByUserQuery
{
    public function __construct(
        public User $user,
        public ?Carbon $dateFrom = null,
        public ?Carbon $dateTo = null,
    ) {
    }
}
