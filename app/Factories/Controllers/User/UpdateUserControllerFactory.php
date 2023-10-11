<?php

namespace App\Factories\Controllers\User;

use App\Factories\UseCases\User\UpdateUserUseCaseFactory;
use Core\Ui\Api\Controllers\User\UpdateUserController;

class UpdateUserControllerFactory
{
    public static function make(): UpdateUserController
    {
        $useCase = UpdateUserUseCaseFactory::make();
        return (new UpdateUserController(
            useCase: $useCase
        ));
    }
}
