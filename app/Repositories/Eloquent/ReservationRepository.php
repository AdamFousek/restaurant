<?php

declare(strict_types=1);


namespace App\Repositories\Eloquent;

use App\Commands\Reservation\CancelReservationCommand;
use App\Models\Reservation;
use App\Queries\Reservation\FindReservationByUserQuery;
use App\Queries\Reservation\FindReservationQuery;
use App\Repositories\ReservationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function byId(int $id): ?Reservation
    {
        $reservation = Reservation::find($id);

        return $reservation instanceof Reservation ? $reservation : null;
    }

    public function findOneByUser(FindReservationByUserQuery $query): ?Reservation
    {
        $builder = $query->user->reservations();

        if ($query->dateFrom !== null) {
            $builder->whereDate('reservation_datetime', '>', $query->dateFrom);
        }

        if ($query->dateTo !== null) {
            $builder->whereDate('reservation_datetime', '<', $query->dateTo);
        }

        $reservation = $builder->latest()->first();

        return $reservation instanceof Reservation ? $reservation : null;
    }

    public function find(FindReservationQuery $query): LengthAwarePaginator
    {
        $builder = Reservation::query();

        if ($query->user !== null) {
            $builder->where('user_id', $query->user->id);
        }

        if ($query->dateFrom !== null) {
            $builder->whereDate('reservation_datetime', '>', $query->dateFrom);
        }

        if ($query->dateTo !== null) {
            $builder->whereDate('reservation_datetime', '<', $query->dateTo);
        }

        if ($query->orderBy !== null) {
            $builder->orderBy($query->orderBy->value, $query->orderDesc ? 'desc' : 'asc');
        }

        return $builder->paginate($query->pagination);
    }

    public function destroy(CancelReservationCommand $command): void
    {
        Log::info("Reservation with id {$command->reservation->id} was canceled by user with id {$command->user->id}" );

        $command->reservation->delete();
    }
}
