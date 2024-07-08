<?php

declare(strict_types=1);


namespace App\Repositories;

use App\Commands\Reservation\CancelReservationCommand;
use App\Commands\Reservation\UpsertReservationCommand;
use App\Models\Reservation;
use App\Queries\Reservation\FindReservationByUserQuery;
use App\Queries\Reservation\FindReservationQuery;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReservationRepositoryInterface
{
    public function upsert(UpsertReservationCommand $command): void;

    public function byId(int $id);

    public function findOneByUser(FindReservationByUserQuery $query): ?Reservation;

    public function find(FindReservationQuery $query): LengthAwarePaginator;

    public function destroy(CancelReservationCommand $command): void;

    public function getTablesByDate(Carbon $date): int;
}
