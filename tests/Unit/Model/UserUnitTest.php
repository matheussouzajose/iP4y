<?php

namespace Tests\Unit\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserUnitTest extends ModelTestCase
{
    protected function model(): User
    {
        return new User();
    }

    /**
     * @return string[]
     */
    protected function traits(): array
    {
        return [
            HasFactory::class
        ];
    }

    /**
     * @return string[]
     */
    protected function fillables(): array
    {
        return [
            'id',
            'first_name',
            'last_name',
            'email',
            'cpf',
            'birthday',
            'genre'
        ];
    }

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'birthday' => 'datetime'
        ];
    }
}
