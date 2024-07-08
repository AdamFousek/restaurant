<?php

declare(strict_types=1);


namespace App\Repositories\Eloquent;

use App\Commands\Reservation\CancelReservationCommand;
use App\Commands\Reservation\UpsertReservationCommand;
use App\Models\Reservation;
use App\Queries\Reservation\FindReservationByUserQuery;
use App\Queries\Reservation\FindReservationQuery;
use App\Repositories\ReservationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class ReservationRepository implements ReservationRepositoryInterface
{

    public function upsert(UpsertReservationCommand $command): void
    {
        Reservation::create([
            'user_id' => $command->user->id,
            'reservation_datetime' => $command->date,
            'number_of_tables' => $command->tables,
            'special_request' => $command->specialRequest,
        ]);
    }

    public function findOneByUser(FindReservationByUserQuery $query): ?Reservation
    {
        $builder = $query->user->reservations();

        if ($query->dateFrom !== null) {
            $builder->whereDate('reservation_datetime', '>=', $query->dateFrom);
        }

        if ($query->dateTo !== null) {
            $builder->whereDate('reservation_datetime', '<=', $query->dateTo);
        }

        $reservation = $builder->orderBy('reservation_datetime', 'asc')->first();

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

    public function getTablesByDate(Carbon $date): int
    {
        $result = Reservation::query()
            ->selectRaw('sum(reservations.number_of_tables) as sum, DATE(reservation_datetime) as date')
            ->whereDate('reservation_datetime', '=', $date)
            ->groupBy('date')->first();

        return (int)$result?->sum;
    }
}
