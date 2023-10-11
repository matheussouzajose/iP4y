<?php

namespace App\Http\Requests;

use Core\Domain\User\Enum\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user');

        return [
            'first_name' => 'filled|string|min:3|max:255',
            'last_name' => 'filled|string|min:3|max:255',
            'email' => 'filled|email|max:255',
            'cpf' => "filled|cpf|unique:users,cpf,$id",
            'birthday' => 'filled|date_format:Y-m-d',
            'genre' => ['filled', new Enum(Genre::class)],
        ];
    }
}
