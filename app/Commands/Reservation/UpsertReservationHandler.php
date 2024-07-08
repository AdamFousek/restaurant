<?php

declare(strict_types=1);


namespace App\Commands\Reservation;

use App\Repositories\ReservationRepositoryInterface;

readonly class UpsertReservationHandler
{
    public function __construct(
        private ReservationRepositoryInterface $repository,
    ) {
    }

    public function handle(UpsertReservationCommand $command): void
    {
        $this->repository->upsert($command);
    }
}
