<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(),
            'number_of_pages' => $this->faker->numberBetween(20,1000),
        ];
    }

    public function fullyRead(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'number_of_read_pages' => $attributes['number_of_pages'],
            ];
        });
    }
}
