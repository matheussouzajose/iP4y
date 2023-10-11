<?php

namespace Core\Domain\Shared\Exception;

class NotFoundException extends \Exception
{
    public static function itemNotFound(string $id): NotFoundException
    {
        $message = sprintf('O item %s não foi encontrado.', $id);
        return new self(
            message: $message,
            code: 403
        );
    }
}
