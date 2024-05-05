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

use App\Http\Controllers\CreateUserReadingIntervalController;
use App\Http\Controllers\MostRecommendedBooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', static fn (Request $request) => $request->user())->middleware('auth:sanctum');

Route::post('users/reading-intervals', CreateUserReadingIntervalController::class)->name('users.reading-intervals.store');

Route::get('books/most-recommended', MostRecommendedBooksController::class)->name('books.most-recommended');
