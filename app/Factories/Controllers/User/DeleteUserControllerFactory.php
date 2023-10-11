<?php

namespace App\Factories\Controllers\User;

use App\Factories\UseCases\User\DeleteUserUseCaseFactory;
use Core\Ui\Api\Controllers\User\DeleteUserController;

class DeleteUserControllerFactory
{
    public static function make(): DeleteUserController
    {
        $useCase = DeleteUserUseCaseFactory::make();
        return (new DeleteUserController(
            useCase: $useCase
        ));
    }
}
