<?php

namespace Core\Application\UseCase\User\Delete;

class DeleteUserInputDto
{
    public function __construct(public string $id)
    {
    }
}
