<?php

declare(strict_types=1);


namespace App\Queries\Reservation;

use App\Models\Reservation;
use App\Repositories\ReservationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class FindReservationByUserHandler
{
    public function __construct(
        private ReservationRepositoryInterface $repository,
    ) {
    }

    /**
     * @param FindReservationByUserQuery $query
     * @return ?Reservation
     */
    public function handle(FindReservationByUserQuery $query): ?Reservation
    {
        return $this->repository->findOneByUser($query);
    }
}
