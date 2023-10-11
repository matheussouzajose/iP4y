<?php

namespace App\Factories\UseCases\User;

use App\Factories\Repositories\User\UserRepositoryFactory;
use Core\Application\UseCase\User\Create\CreateUserUseCase;

class CreateUserUseCaseFactory
{
    public static function make(): CreateUserUseCase
    {
        $repository = UserRepositoryFactory::make();
        return new CreateUserUseCase(repository: $repository);
    }
}
