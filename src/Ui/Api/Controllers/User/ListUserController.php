<?php

namespace Core\Ui\Api\Controllers\User;

use Core\Application\UseCase\User\Create\CreateUserOutputDto;
use Core\Application\UseCase\User\List\ListUserInputDto;
use Core\Application\UseCase\User\List\ListUserUseCase;

class ListUserController
{
    public function __construct(protected ListUserUseCase $useCase)
    {
    }

    public function __invoke(string $id): CreateUserOutputDto
    {
        return ($this->useCase)($this->createFromRequest($id));
    }

    private function createFromRequest(string $id): ListUserInputDto
    {
        return new ListUserInputDto(
            id: $id
        );
    }
}
