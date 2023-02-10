<?php

namespace Database\Factories;

use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guest>
 */
class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => Guest::all()->random()->id,
            'name' => fake()->name,
            'companions' => fake()->numberBetween(0, 5),
            'package_id' => fake()->numberBetween(1, 5),
        ];
    }
}
