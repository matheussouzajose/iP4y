<?php

namespace App\Factories\UseCases\User;

use App\Factories\Repositories\User\UserRepositoryFactory;
use Core\Application\UseCase\User\List\ListUserUseCase;

class ListUserUseCaseFactory
{
    public static function make(): ListUserUseCase
    {
        $repository = UserRepositoryFactory::make();
        return (new ListUserUseCase(
            repository: $repository
        ));
    }
}
