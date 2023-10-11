<?php

namespace Core\Domain\User\Exception;

class CpfInvalidException extends \Exception
{
    public static function itemInvalid(string $cpf): CpfInvalidException
    {
        $message = sprintf('O cpf %s não é um CPF válido.', $cpf);
        return new self(
            message: $message,
            code: 422
        );
    }
}
