<?php

namespace App\Http\Requests;

use Core\Domain\User\Enum\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'cpf' => "required|cpf|regex:/^\d{11}$/|size:11|unique:users",
            'birthday' => 'required|date_format:Y-m-d',
            'genre' => ['required', new Enum(Genre::class)],
        ];
    }
}
