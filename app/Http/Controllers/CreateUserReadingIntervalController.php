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
        ReadingInterval::create($request->validated());

        return response()->json(['message' => 'Reading interval submitted successfully'], 201);
    }
}
