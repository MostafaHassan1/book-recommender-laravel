<?php

use App\Http\Controllers\MostRecommendedBooksController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('books/most-recommended',MostRecommendedBooksController::class)->name('books.most-recommended');
