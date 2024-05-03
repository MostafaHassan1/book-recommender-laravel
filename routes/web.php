<?php

use App\Http\Controllers\CreateUserReadingIntervalController;
use App\Http\Controllers\MostRecommendedBooksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('users/reading-intervals',CreateUserReadingIntervalController::class)->name('users.reading-intervals.store');

Route::get('books/most-recommended',MostRecommendedBooksController::class)->name('books.most-recommended');
