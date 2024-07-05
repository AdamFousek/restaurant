<?php

declare(strict_types=1);


namespace App\Commands\Reservation;

use App\Repositories\ReservationRepositoryInterface;

readonly class CancelReservationHandler
{
    public function __construct(
        private ReservationRepositoryInterface $repository,
    ) {
    }

    public function handle(CancelReservationCommand $command): void
    {
        $this->repository->destroy($command);
    }
}
