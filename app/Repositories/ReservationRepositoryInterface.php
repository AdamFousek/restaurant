<?php

declare(strict_types=1);


namespace App\Repositories;

use App\Commands\Reservation\CancelReservationCommand;
use App\Models\Reservation;
use App\Queries\Reservation\FindReservationByUserQuery;
use App\Queries\Reservation\FindReservationQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReservationRepositoryInterface
{
    public function byId(int $id);

    public function findOneByUser(FindReservationByUserQuery $query): ?Reservation;

    public function find(FindReservationQuery $query): LengthAwarePaginator;

    public function destroy(CancelReservationCommand $command): void;
}