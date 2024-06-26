<?php

use App\Models\Book;
use App\Models\ReadingInterval;
use Illuminate\Support\Facades\Notification;

test('can calculate number of read pages', function (array $intervals, $numberOfReadPages) {
    Notification::fake();

    $book = Book::factory()->create();

    foreach ($intervals as $interval) {
        ReadingInterval::factory($interval)->for($book)->create();
    }

    expect($book->refresh()->number_of_read_pages)
        ->toEqual($numberOfReadPages);
})->with([
    'task first case' => fn () => [
        [
            ['start_page' => 10, 'end_page' => 30],
            ['start_page' => 2, 'end_page' => 25],
        ], 28,
    ],
    'task 2nd case' => fn () => [
        [
            ['start_page' => 40, 'end_page' => 50],
            ['start_page' => 1, 'end_page' => 10],
        ], 20,
    ],
    'reverse task first case' => fn () => [
        [
            ['start_page' => 2, 'end_page' => 25],
            ['start_page' => 10, 'end_page' => 30],
        ], 28,
    ],
    'reverse task 2nd case' => fn () => [
        [
            ['start_page' => 1, 'end_page' => 10],
            ['start_page' => 40, 'end_page' => 50],
        ], 20,
    ],
    'same starting page' => fn () => [
        [
            ['start_page' => 1, 'end_page' => 30],
            ['start_page' => 1, 'end_page' => 35],
        ], 35,
    ],
    'same ending page' => fn () => [
        [
            ['start_page' => 10, 'end_page' => 20],
            ['start_page' => 1, 'end_page' => 20],
        ], 20,
    ],
    'full intersect' => fn () => [
        [
            ['start_page' => 1, 'end_page' => 20],
            ['start_page' => 1, 'end_page' => 10],
        ], 20,
    ],
    'repeated intervals' => fn () => [
        [
            ['start_page' => 1, 'end_page' => 20],
            ['start_page' => 1, 'end_page' => 20],
        ], 20,
    ],
    'more intervals' => fn () => [
        [
            ['start_page' => 1, 'end_page' => 20],
            ['start_page' => 1, 'end_page' => 10],
            ['start_page' => 20, 'end_page' => 30],
            ['start_page' => 25, 'end_page' => 33],
        ], 33,
    ],
    'more intervals with gaps' => fn () => [
        [
            ['start_page' => 1, 'end_page' => 20],
            ['start_page' => 1, 'end_page' => 10],
            ['start_page' => 30, 'end_page' => 40],
            ['start_page' => 35, 'end_page' => 43],
        ], 33,
    ],
    'only one page' => fn () => [
        [
            ['start_page' => 1, 'end_page' => 1],
            ['start_page' => 1, 'end_page' => 1],
            ['start_page' => 1, 'end_page' => 1],
        ], 1,
    ],
]);

test('intersected intervals get merged', function () {
    $book = Book::factory()->create();

    ReadingInterval::factory([
        'start_page' => 20,
        'end_page'   => 30,
    ])->for($book)->create();
    $interval = ReadingInterval::factory([
        'start_page' => 1,
        'end_page'   => 20,
    ])->for($book)->create();

    $this->assertDatabaseHas('reading_intervals', [
        'book_id'    => $book->id,
        'id'         => $interval->id,
        'start_page' => 1,
        'end_page'   => 30,
        'merged'     => false,
    ]);

    $this->assertDatabaseHas('reading_intervals', [
        'book_id'    => $book->id,
        'start_page' => 20,
        'end_page'   => 30,
        'merged'     => true,
    ]);
});

test('not intersected intervals does not get merged', function () {
    $book = Book::factory()->create();

    ReadingInterval::factory([
        'start_page' => 20,
        'end_page'   => 30,
    ])->for($book)->create();
    $interval = ReadingInterval::factory([
        'start_page' => 1,
        'end_page'   => 19,
    ])->for($book)->create();

    $this->assertDatabaseHas('reading_intervals', [
        'book_id'    => $book->id,
        'id'         => $interval->id,
        'start_page' => 1,
        'end_page'   => 19,
        'merged'     => false,
    ]);

    $this->assertDatabaseHas('reading_intervals', [
        'book_id'    => $book->id,
        'start_page' => 20,
        'end_page'   => 30,
        'merged'     => false,
    ]);
});
