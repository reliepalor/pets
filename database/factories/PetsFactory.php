<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\pets>
 */
class PetsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> fake()->firstName(),
            'breed' => fake()->randomElement(['Shit Zu', 'Persian','Maine Coon','Pit Bull'] ),
            'quantity' => fake()->randomNumber(1,5),
            'age' => fake()->randomNumber(1,5),
        ];
    }
}
