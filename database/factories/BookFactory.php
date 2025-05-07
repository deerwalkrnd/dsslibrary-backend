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
            //
            'title' => $this->faker->sentence(3), // random 3-word title
            'author' => $this->faker->name(),       // random author name
            'isbn' => $this->faker->isbn13(),     // random ISBN-13
            'remaining' => $this->faker->numberBetween(0, 100),
            'uuid' => $this->faker->numberBetween(0, 100),
            'status' => 'available',
        ];
    }
}
