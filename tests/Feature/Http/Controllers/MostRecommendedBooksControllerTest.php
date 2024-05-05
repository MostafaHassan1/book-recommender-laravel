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

test('can get books sorted by most read pages', function (): void {
    $mostReadBook = Book::factory([
        'number_of_pages' => 100,
    ])->fullyRead()->create();

    $secondMostReadBook = Book::factory([
        'number_of_pages' => 90,
    ])->fullyRead()->create();

    $thirdMostReadBook = Book::factory([
        'number_of_pages' => 100,
        'number_of_read_pages' => 50,
    ])->create();

    $this->get(route('books.most-recommended'))
        ->assertOk()
        ->assertSeeInOrder([$mostReadBook->id, $secondMostReadBook->id, $thirdMostReadBook->id])
    ;
});
