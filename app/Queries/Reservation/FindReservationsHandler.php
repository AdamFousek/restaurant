<?php

declare(strict_types=1);


namespace App\Queries\Reservation;

use App\Repositories\ReservationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

readonly class FindReservationsHandler
{
    public function __construct(
        private ReservationRepositoryInterface $repository,
    ) {
    }

    public function handle(FindReservationQuery $query): LengthAwarePaginator
    {
        return $this->repository->find($query);
    }
}
