<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class MostRecommendedBooksController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $booksSortedByMostReadPages = Book::mostRead()->get();

        return response()->json(BookResource::collection($booksSortedByMostReadPages));
    }
}
