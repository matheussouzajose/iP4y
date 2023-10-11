<?php

namespace Core\Domain\User\Factory;

use Core\Domain\Shared\Validation\ValidatorInterface;
use Core\Domain\User\Validation\UserValidator;

class UserValidatorFactory
{
    public static function create(): ValidatorInterface
    {
        return new UserValidator();
    }
}
