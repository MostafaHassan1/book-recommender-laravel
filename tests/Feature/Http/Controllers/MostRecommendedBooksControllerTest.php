<?php

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('can get books sorted by most read pages',function (){
    $mostReadBook = Book::factory([
        'number_of_pages' => 100
    ])->fullyRead()->create();

    $secondMostReadBook = Book::factory([
        'number_of_pages' => 90
    ])->fullyRead()->create();

    $thirdMostReadBook = Book::factory([
        'number_of_pages' => 100,
        'number_of_read_pages' => 50
    ])->create();

    $this->get(route('books.most-recommended'))
        ->assertOk()
        ->assertSeeInOrder([$mostReadBook->id,$secondMostReadBook->id,$thirdMostReadBook->id]);
});
