<?php

namespace Tests\Unit\Reservation;

use App\Models\Reservation;
use App\Transformers\Controllers\ReservationsTransformer;
use Carbon\Carbon;
use Tests\TestCase;

class ReservationTransformerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_reservation_transformer(): void
    {
        $reservationTransformer = new ReservationsTransformer();

        $reservation = Reservation::make([
            'id' => 1,
            'reservation_datetime' => new Carbon(),
            'number_of_tables' => 2,
            'special_request' => 'U okna',
            'is_confirmed' => true,
        ]);

        $transformedData = $reservationTransformer->transform(collect([$reservation]));

        $this->assertIsArray($transformedData);

        $oneReservation = array_pop($transformedData);
        $this->assertArrayHasKey('id', $oneReservation);
        $this->assertArrayHasKey('numberOfTables', $oneReservation);
        $this->assertArrayHasKey('reservationDatetime', $oneReservation);
        $this->assertArrayHasKey('specialRequest', $oneReservation);
        $this->assertArrayHasKey('isConfirmed', $oneReservation);
        $this->assertArrayHasKey('canBeRemoved', $oneReservation);
    }
}
