<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string|min:40',
            'author' => 'required|string'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
