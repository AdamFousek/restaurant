<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')),
            'number_of_tables' => $this->faker->numberBetween(1, config('restaurant.max_tables')),
            'reservation_datetime' => $this->faker->dateTimeBetween('now', '+1 month'),
            'special_request' => random_int(0, 1) ? $this->faker->sentence : '',
            'is_confirmed' => (bool)random_int(0, 1),
        ];
    }
}
