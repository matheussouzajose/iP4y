<?php

namespace Core\Ui\Api\Controllers\User;

use App\Http\Requests\UpdateUserRequest;
use Core\Application\UseCase\User\Update\UpdateUserInputDto;
use Core\Application\UseCase\User\Update\UpdateUserOutputDto;
use Core\Application\UseCase\User\Update\UpdateUserUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Exception\CpfInvalidException;
use Illuminate\Contracts\Container\BindingResolutionException;

class UpdateUserController
{
    public function __construct(protected UpdateUserUseCase $useCase)
    {
    }


    /**
     * @throws BindingResolutionException
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function __invoke(UpdateUserRequest $request, string $id): UpdateUserOutputDto
    {
        return ($this->useCase)($this->createFromRequest($request, $id));
    }

    private function createFromRequest(UpdateUserRequest $request, string $id): UpdateUserInputDto
    {
        return new UpdateUserInputDto(
            id: $id,
            firstName: $request->first_name,
            lastName: $request->last_name,
            email: $request->email,
            birthday: $request->birthday,
            cpf: $request->cpf,
            genre: $request->genre
        );
    }
}
