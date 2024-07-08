<?php

namespace Tests\Feature\Reservation;

use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase, CreateUserTrait;

    /**
     * A basic feature test example.
     */
    public function test_reservation_index(): void
    {
        $user = $this->createUser();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->get(route('reservations.index'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Reservations/Index')
                ->has('reservations', 1)
                ->has('reservations.0', fn (Assert $page) => $page
                    ->where('id', $reservation->id)
                    ->where('numberOfTables', $reservation->number_of_tables)
                    ->where('reservationDatetime', $reservation->reservation_datetime->format('j.n.Y H:i:s'))
                    ->where('specialRequest', $reservation->special_request)
                    ->where('isConfirmed', $reservation->is_confirmed)
                    ->has('canBeRemoved')
                )
                ->has('paginate')
            );
    }

    public function test_reservation_create(): void
    {
        $user = $this->createUser();
        $this->actingAs($user)
            ->get(route('reservations.create'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Reservations/Create')
                ->has('minHour')
                ->has('maxHour')
                ->has('availableDays')
                ->has('availableDays.0', fn (Assert $page) => $page
                    ->has('day')
                    ->has('dayFormatted')
                    ->has('availableTables')
                )
            );
    }
}
