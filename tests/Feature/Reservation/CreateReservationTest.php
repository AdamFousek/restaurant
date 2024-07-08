<?php

namespace Tests\Feature\Reservation;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class CreateReservationTest extends TestCase
{
    use RefreshDatabase, CreateUserTrait;

    /**
     * A basic feature test example.
     */
    public function test_create_reservation(): void
    {
        $user = $this->createUser();

        $date = (new Carbon())->addDay();
        $response = $this->actingAs($user)->post(route('reservations.store', [
            'date' => $date->format('d.m.Y H:i'),
            'numberOfTables' => 2,
            'specialRequest' => 1,
        ]));

        $response->assertRedirectToRoute('reservations.index');

        $reservation = Reservation::where('user_id', $user->id)->first();
        $this->assertNotNull($reservation);
        $this->assertEquals($date->format('d.m.Y H:i'), $reservation->reservation_datetime->format('d.m.Y H:i'));
        $this->assertEquals(2, $reservation->number_of_tables);
        $this->assertEquals(1, $reservation->special_request);
    }

    public function test_reservation_store_tables_occupied(): void
    {
        $date = (new Carbon())->addDay();
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->post(route('reservations.store', [
                'date' => $date->format('d.m.Y H:i'),
                'numberOfTables' => 31,
                'specialRequest' => 'test',
                ]
            ));

        $response->assertRedirect();
        $response->assertSessionHas('alert');
        $flash = session('alert');
        $this->assertEquals('error', $flash['type']);
    }

    public function test_reservation_store_error(): void
    {
        $user = $this->createUser();
        $response = $this->actingAs($user)
            ->post(route('reservations.store', [
                'date' => 'invalid date',
                'numberOfTables' => 31,
                'specialRequest' => 'test',
                ]
            ));

        $response->assertRedirect();
    }
}
