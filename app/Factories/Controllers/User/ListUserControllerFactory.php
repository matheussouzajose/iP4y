<?php

namespace App\Factories\Controllers\User;

use App\Factories\UseCases\User\ListUserUseCaseFactory;
use Core\Ui\Api\Controllers\User\ListUserController;

class ListUserControllerFactory
{
    public static function make(): ListUserController
    {
        $useCase = ListUserUseCaseFactory::make();
        return (new ListUserController(
            useCase: $useCase
        ));
    }
}
