<?php

declare(strict_types=1);


namespace App\Queries\Reservation;

use App\Models\User;
use App\Repositories\Enum\ReservationOrderByEnum;
use Illuminate\Support\Carbon;

readonly class FindReservationQuery
{
    public function __construct(
        public ?User $user = null,
        public ?Carbon $dateFrom = null,
        public ?Carbon $dateTo = null,
        public int $pagination = 10,
        public ?ReservationOrderByEnum $orderBy = null,
        public bool $orderDesc = false,
    ) {
    }
}
