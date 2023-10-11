<?php

namespace App\Factories\Repositories\User;

use App\Models\User;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;

class UserRepositoryFactory
{
    public static function make(): UserRepository
    {
        return new UserRepository(
            model: new User()
        );
    }
}
