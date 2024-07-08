<?php

namespace Tests\Unit\Reservation;

use App\Models\Reservation;
use App\Services\ReservationService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class ReservationServiceTest extends TestCase
{
    use CreateUserTrait, RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $user = $this->createUser();
        $datetime = new Carbon();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'reservation_datetime' => $datetime,
            'number_of_tables' => 25,
        ]);

        /** @var ReservationService $reservationService */
        $reservationService = app(ReservationService::class);

        $response = $reservationService->resolveDays($datetime->copy(), $datetime->copy());

        $this->assertIsArray($response);
        $oneDay = array_pop($response);
        $this->assertArrayHasKey('day', $oneDay);
        $this->assertArrayHasKey('dayFormatted', $oneDay);
        $this->assertArrayHasKey('availableTables', $oneDay);

        $this->assertEquals($datetime->format('m.d.Y'), $oneDay['day']);
        $this->assertEquals($datetime->format('d.m.Y'), $oneDay['dayFormatted']);
        $this->assertEquals(5, $oneDay['availableTables']);
    }
}
