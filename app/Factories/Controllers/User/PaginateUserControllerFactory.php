<?php

namespace App\Factories\Controllers\User;

use App\Factories\UseCases\User\PaginateUserUseCaseFactory;
use Core\Ui\Api\Controllers\User\PaginateUserController;

class PaginateUserControllerFactory
{
    public static function make(): PaginateUserController
    {
        $useCase = PaginateUserUseCaseFactory::make();
        return (new PaginateUserController(
            useCase: $useCase
        ));
    }
}
