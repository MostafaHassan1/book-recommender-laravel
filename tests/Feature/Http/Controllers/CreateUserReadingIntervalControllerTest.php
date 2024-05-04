<?php

use App\Models\Book;
use App\Models\User;

todo('can create reading interval for a user');

test('throws validation error',function ($user,$book,$startPage,$endPage,$validationErrorKey){
    $this->post(route('users.reading-intervals.store'),[
        'user_id' => $user?->id,
        'book_id' => $book?->id,
        'start_page'=> $startPage,
        'end_page' => $endPage,
    ])->assertInvalid($validationErrorKey);
})->with([
    'user not found' =>
        fn()=>[
            null,
            null,
            -1,
            10,
            'user_id'
        ],
    'book not found' =>
        fn()=>[
            User::factory()->create(),
            null,
            -1,
            10,
            'book_id'
        ],
    'start page is bigger than the book\'s number_of_pages' =>
        fn()=>[
            User::factory()->create(),
            $book = Book::factory()->create(),
            $book->number_of_pages + 1,
            10,
            'start_page'
        ],
    'start page is less than 1' =>
        fn()=>[
            User::factory()->create(),
            Book::factory()->create(),
            -1,
            10,
            'start_page'
        ],
    'end page is bigger than the book\'s number_of_pages' =>
        fn()=>[
            User::factory()->create(),
            $book = Book::factory()->create(),
            1,
            $book->number_of_pages + 1,
            'end_page'
        ],
    'end page is less than start page' =>
        fn()=>[
            User::factory()->create(),
            $book = Book::factory()->create(),
            $book->number_of_pages ,
            $book->number_of_pages - 1,
            'end_page'
        ],
]);
