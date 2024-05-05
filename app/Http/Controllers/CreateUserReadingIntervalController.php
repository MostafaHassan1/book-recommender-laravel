<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserReadingIntervalRequest;
use App\Models\ReadingInterval;

class CreateUserReadingIntervalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserReadingIntervalRequest $request)
    {
        $readingInterval = ReadingInterval::create($request->validated());

        response()->json($readingInterval,201);
    }
}
