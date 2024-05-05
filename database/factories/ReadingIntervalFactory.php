<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReadingInterval>
 */
class ReadingIntervalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'book_id' => Book::factory(),
            'start_page' => function (array $attributes) {
                $book = Book::find($attributes['book_id']);

                return $this->faker->numberBetween(1, $book->number_of_pages);
            },
            'end_page' => function (array $attributes) {
                $book = Book::find($attributes['book_id']);

                return $this->faker->numberBetween($attributes['start_page'], $book->number_of_pages);
            },
        ];
    }
}
