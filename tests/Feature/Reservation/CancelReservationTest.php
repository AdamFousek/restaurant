<?php

namespace Tests\Feature\Reservation;

use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Traits\CreateUserTrait;

class CancelReservationTest extends TestCase
{
    use RefreshDatabase, CreateUserTrait;
    /**
     * A basic feature test example.
     */
    public function test_cancel_reservation(): void
    {
        $user = $this->createUser();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('reservations.destroy', ['reservation' => $reservation]));

        $response->assertRedirectToRoute('reservations.index');
        $this->assertTrue($reservation->refresh()->trashed());
    }
}
