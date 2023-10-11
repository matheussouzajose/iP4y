<?php

namespace App\Factories\UseCases\User;

use App\Factories\Repositories\User\UserRepositoryFactory;
use Core\Application\UseCase\User\Paginate\PaginateUserUseCase;

class PaginateUserUseCaseFactory
{
    public static function make(): PaginateUserUseCase
    {
        $repository = UserRepositoryFactory::make();
        return (new PaginateUserUseCase(
            repository: $repository
        ));
    }
}
