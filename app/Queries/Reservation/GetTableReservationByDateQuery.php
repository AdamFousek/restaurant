<?php

declare(strict_types=1);


namespace App\Queries\Reservation;

use Carbon\Carbon;

readonly class GetTableReservationByDateQuery
{
    public function __construct(
        public Carbon $date,
    ) {
    }
}
