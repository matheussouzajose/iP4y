<?php

namespace Core\Application\UseCase\User\Update;

use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Entity\User;
use Core\Domain\User\Enum\Genre;
use Core\Domain\User\Exception\CpfInvalidException;
use Core\Domain\User\ObjectValues\Cpf;
use Core\Domain\User\Repository\UserRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;

class UpdateUserUseCase
{
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @throws BindingResolutionException
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function __invoke(UpdateUserInputDto $input): UpdateUserOutputDto
    {
        $user = $this->repository->findById($input->id);

        $user->update(
            firstName: $input->firstName ?: $user->firstName,
            lastName: $input->lastName ?: $user->lastName,
            email: $input->email ?: $user->email,
            genre: $input->genre ? Genre::from($input->genre) : $user->genre,
            cpf: $input->cpf ? new Cpf($input->cpf) : $user->cpf,
            birthday: $input->birthday ? new \DateTime($input->birthday) : $user->birthday
        );

        $result = $this->repository->update($user);

        return $this->updateUserOutputDto($result);
    }

    private function updateUserOutputDto(User $entity): UpdateUserOutputDto
    {
        return new UpdateUserOutputDto(
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
