<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tag::class;

    public function definition()
    {


        $property_features = [
            'Free WiFi',
            'Family rooms',
            'Bar',
            'Park',
            'Parking',
            'Restaurant',
            'Cafe',
            'Tea/Coffee Maker in All Rooms',
        ];

        return [

        ];
    }
}
