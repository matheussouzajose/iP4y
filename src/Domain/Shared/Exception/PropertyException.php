<?php

namespace Core\Domain\Shared\Exception;

class PropertyException extends \Exception
{
    public static function propertyNotFound(string $id, string $className): PropertyException
    {
        $message = sprintf('Property %s not found in class %s', $id, $className);
        return new self(
            message: $message,
            code: 403
        );
    }
}
