<?php

namespace Core\Domain\Shared\Validation;

use Core\Domain\Shared\Entity\Entity;

interface ValidatorInterface
{
    public function validate(Entity $entity): void;
}
