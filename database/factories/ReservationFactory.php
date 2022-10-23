<?php

namespace Database\Factories;

use App\Models\Office;
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
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'office_id' => Office::factory(),
            'price' => $this->faker->numberBetween(10_00, 20_00),
            'status' => 1,
            'start_date' => now()->addDay(1)->format('Y-m-d'),
            'end_date' => now()->addDays(5)->format('Y-m-d'),
        ];
    }
}
