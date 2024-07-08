<?php

namespace Tests\Feature\Dashboard;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class DashboardControllerTest extends TestCase
{
    use CreateUserTrait, RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_dashboard_controller(): void
    {
        $user = $this->createUser();

        $reservation = $user->reservations()->create([
            'reservation_datetime' => (new Carbon)->addDay(),
            'number_of_tables' => 2,
            'special_request' => 1,
            'is_confirmed' => false,
        ]);

        $response = $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->has('reservation')
                ->has('reservation', fn (Assert $page) => $page
                    ->where('id', $reservation->id)
                    ->where('numberOfTables', $reservation->number_of_tables)
                    ->where('reservationDatetime', $reservation->reservation_datetime->format('j.n.Y H:i:s'))
                    ->where('specialRequest', $reservation->special_request)
                    ->where('isConfirmed', $reservation->is_confirmed)
                    ->has('canBeRemoved')
                )
            );

        $response->assertStatus(200);
    }
}
