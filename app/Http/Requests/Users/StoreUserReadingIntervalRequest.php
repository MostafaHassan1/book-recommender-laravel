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

namespace App\Http\Requests\Users;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserReadingIntervalRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<mixed>|\Illuminate\Contracts\Validation\ValidationRule|string>
     */
    public function rules(): array
    {
        $book = Book::find($this->input('book_id'));

        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'start_page' => [
                'required',
                'integer',
                'min:1',
                static function ($attribute, $value, $fail) use ($book): void {
                    if ($value > $book->number_of_pages) {
                        $fail('Invalid start page.');
                    }
                },
            ],
            'end_page' => [
                'required',
                'gte:start_page',
                static function ($attribute, $value, $fail) use ($book): void {
                    if ($value > $book->number_of_pages) {
                        $fail('Invalid end page.');
                    }
                },
            ],
        ];
    }
}
