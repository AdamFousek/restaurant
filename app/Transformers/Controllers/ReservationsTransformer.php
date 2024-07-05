<?php

declare(strict_types=1);


namespace App\Transformers\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReservationsTransformer
{
    /**
     * @param Collection<Reservation> $collection
     * @return array []|array<array{
     *      id: integer,
     *      numberOfTables: integer,
     *      reservationDatetime: string,
     *      specialRequest: string,
     *      isConfirmed: boolean
     * }>
     */
    public function transform(Collection $collection): array
    {
        $result = [];
        foreach ($collection as $reservation) {
            if (!$reservation instanceof Reservation) {
                continue;
            }

            $result[] = $this->transformOne($reservation);
        }

        return $result;
    }

    /**
     * @param Reservation $reservation
     * @return array{
     *     id: integer,
     *     numberOfTables: integer,
     *     reservationDatetime: string,
     *     specialRequest: string,
     *     isConfirmed: boolean
     * }
     */
    public function transformOne(Reservation $reservation): array
    {
        return [
            'id' => $reservation->id,
            'numberOfTables' => $reservation->number_of_tables,
            'reservationDatetime' => $reservation->reservation_datetime->format('j.n.Y H:i:s'),
            'specialRequest' => $reservation->special_request,
            'isConfirmed' => $reservation->is_confirmed,
            'canBeRemoved' => (bool)$reservation->reservation_datetime->diffInDays(new Carbon())
        ];
    }
}
