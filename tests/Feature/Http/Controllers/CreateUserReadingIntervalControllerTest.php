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

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

test('can create reading interval for a user', function (): void {
    Notification::fake();
    $user = User::factory()->create();
    $book = Book::factory()->create();
    $this->post(route('users.reading-intervals.store'), [
        'user_id' => $user->id,
        'book_id' => $book->id,
        'start_page' => 1,
        'end_page' => $book->number_of_pages,
    ])->assertSuccessful();

    $this->assertDatabaseCount('reading_intervals', 1);
});

test('throws validation error', function ($user, $book, $startPage, $endPage, $validationErrorKey): void {
    Notification::fake();
    $this->post(route('users.reading-intervals.store'), [
        'user_id' => $user?->id,
        'book_id' => $book?->id,
        'start_page' => $startPage,
        'end_page' => $endPage,
    ])->assertInvalid($validationErrorKey);
})->with([
    'user not found' => static fn () => [
        null,
        null,
        -1,
        10,
        'user_id',
    ],
    'book not found' => static fn () => [
        User::factory()->create(),
        null,
        -1,
        10,
        'book_id',
    ],
    'start page is bigger than the book\'s number_of_pages' => static fn () => [
        User::factory()->create(),
        $book = Book::factory()->create(),
        $book->number_of_pages + 1,
        10,
        'start_page',
    ],
    'start page is less than 1' => static fn () => [
        User::factory()->create(),
        Book::factory()->create(),
        -1,
        10,
        'start_page',
    ],
    'end page is bigger than the book\'s number_of_pages' => static fn () => [
        User::factory()->create(),
        $book = Book::factory()->create(),
        1,
        $book->number_of_pages + 1,
        'end_page',
    ],
    'end page is less than start page' => static fn () => [
        User::factory()->create(),
        $book = Book::factory()->create(),
        $book->number_of_pages,
        $book->number_of_pages - 1,
        'end_page',
    ],
]);
