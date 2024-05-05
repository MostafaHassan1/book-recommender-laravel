<?php

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $book = Book::find($this->input('book_id'));

        return [
            'user_id'    => 'required|exists:users,id',
            'book_id'    => 'required|exists:books,id',
            'start_page' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($book) {
                    if ($value > $book->number_of_pages) {
                        $fail('Invalid start page.');
                    }
                },
            ],
            'end_page' => [
                'required',
                'gte:start_page',
                function ($attribute, $value, $fail) use ($book) {
                    if ($value > $book->number_of_pages) {
                        $fail('Invalid end page.');
                    }
                },
            ],
        ];
    }
}
