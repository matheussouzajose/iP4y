<?php

namespace App\Factories\UseCases\User;

use App\Factories\Repositories\User\UserRepositoryFactory;
use Core\Application\UseCase\User\Update\UpdateUserUseCase;

class UpdateUserUseCaseFactory
{
    public static function make(): UpdateUserUseCase
    {
        $repository = UserRepositoryFactory::make();
        return (new UpdateUserUseCase(
            repository: $repository
        ));
    }
}
