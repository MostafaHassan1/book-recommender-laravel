<?php

namespace App\Http\Requests\Users;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserReadingIntervalRequest extends FormRequest
{
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
        return [
            'user_id' => 'required|exists:users',
            'book_id' => 'required|exists:books',
            'start_page' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $book = Book::find($this->input('book_id'));
                    if ($value > $book->number_of_pages) {
                        $fail('Invalid start page.');
                    }
                },
            ],
            'end_page' => [
                'required',
                function ($attribute, $value, $fail) {
                    $book = Book::find($this->input('book_id'));
                    $startPage = $this->input('start_page');
                    if ($value < $startPage || $value > $book->number_of_pages) {
                        $fail('Invalid end page.');
                    }
                },
            ],
        ];
    }
}
