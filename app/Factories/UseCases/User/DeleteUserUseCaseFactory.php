<?php

namespace App\Factories\UseCases\User;

use App\Factories\Repositories\User\UserRepositoryFactory;
use Core\Application\UseCase\User\Delete\DeleteUserUseCase;

class DeleteUserUseCaseFactory
{
    public static function make(): DeleteUserUseCase
    {
        return (new DeleteUserUseCase(
            repository: UserRepositoryFactory::make()
        ));
    }
}
