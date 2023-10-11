<?php

namespace App\Factories\Controllers\User;

use App\Factories\UseCases\User\CreateUserUseCaseFactory;
use Core\Ui\Api\Controllers\User\CreateUserController;

class CreateUserControllerFactory
{
    public static function make(): CreateUserController
    {
        $useCase = CreateUserUseCaseFactory::make();
        return (new CreateUserController(useCase: $useCase));
    }
}
