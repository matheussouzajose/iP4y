<?php

namespace Core\Ui\Api\Controllers\User;

use App\Http\Requests\StoreUserRequest;
use Core\Application\UseCase\User\Create\CreateUserInputDto;
use Core\Application\UseCase\User\Create\CreateUserOutputDto;
use Core\Application\UseCase\User\Create\CreateUserUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Exception\CpfInvalidException;

class CreateUserController
{
    public function __construct(protected CreateUserUseCase $useCase)
    {
    }

    /**
     * @throws CpfInvalidException
     * @throws NotificationException
     */
    public function __invoke(StoreUserRequest $request): CreateUserOutputDto
    {
        return ($this->useCase)($this->createFromRequest($request));
    }

    private function createFromRequest(StoreUserRequest $request): CreateUserInputDto
    {
        return new CreateUserInputDto(
            firstName: $request->first_name,
            lastName: $request->last_name,
            email: $request->email,
            birthday: $request->birthday,
            cpf: $request->cpf,
            genre: $request->genre
        );
    }
}
