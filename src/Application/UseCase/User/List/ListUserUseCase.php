<?php

namespace Core\Application\UseCase\User\List;

use Core\Application\UseCase\User\Create\CreateUserOutputDto;
use Core\Domain\User\Entity\User;
use Core\Domain\User\Repository\UserRepositoryInterface;

class ListUserUseCase
{
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    public function __invoke(ListUserInputDto $input): CreateUserOutputDto
    {
        $user = $this->repository->findById($input->id);

        return $this->listUserOutputDto($user);
    }

    private function listUserOutputDto(User $entity): CreateUserOutputDto
    {
        return new CreateUserOutputDto(
            id: $entity->id(),
            firstName: $entity->firstName,
            lastName: $entity->lastName,
            email: $entity->email,
            birthday: $entity->birthday(),
            cpf: $entity->cpf(),
            genre: $entity->genreValue()
        );
    }
}
