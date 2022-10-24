<?php

namespace Database\Factories;

use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Office>
 */
class OfficeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'          => User::factory(),
            'title'            => $this->faker->sentence,
            'description'      => $this->faker->paragraph,
            'lat'              => $this->faker->latitude,
            'lng'              => $this->faker->longitude,
            'address_line_1'   => $this->faker->address,
            'approval_status'  => Office::APPROVAL_APPROVED,
            'hidden'           => false,
            'price_per_day'    => $this->faker->numberBetween(1_000, 2_000),
            'monthly_discount' => 0,
        ];
    }
}
