<?php

declare(strict_types=1);


namespace App\Queries\Reservation;

use App\Repositories\ReservationRepositoryInterface;

readonly class GetTableReservationByDateHandler
{
    public function __construct(
        private ReservationRepositoryInterface $repository,
    ) {
    }

    public function handle(GetTableReservationByDateQuery $query): int
    {
        return $this->repository->getTablesByDate($query->date);
    }
}
