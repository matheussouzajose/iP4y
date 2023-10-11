<?php

namespace Core\Ui\Api\Controllers\User;

use Core\Application\UseCase\User\Delete\DeleteUserInputDto;
use Core\Application\UseCase\User\Delete\DeleteUserUseCase;

class DeleteUserController
{
    public function __construct(protected DeleteUserUseCase $useCase)
    {
    }

    public function __invoke(string $id): bool
    {
        return ($this->useCase)($this->createFromRequest($id));
    }

    private function createFromRequest(string $id): DeleteUserInputDto
    {
        return new DeleteUserInputDto(
            id: $id
        );
    }
}
