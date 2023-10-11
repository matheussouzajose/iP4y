<?php

namespace Core\Domain\User\Exception;

class CpfAlreadyInUseException extends \Exception
{
    public static function itemInUse(string $cpf): CpfAlreadyInUseException
    {
        $message = sprintf('O cpf "%s" já está em uso.', $cpf);
        return new self(
            message: $message,
            code: 422
        );
    }
}
