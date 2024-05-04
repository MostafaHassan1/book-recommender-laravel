<?php

use App\Http\Controllers\CreateUserReadingIntervalController;
use App\Http\Controllers\MostRecommendedBooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('users/reading-intervals',CreateUserReadingIntervalController::class)->name('users.reading-intervals.store');

Route::get('books/most-recommended',MostRecommendedBooksController::class)->name('books.most-recommended');
