<?php

namespace Core\Application\UseCase\User\Create;

use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Entity\User;
use Core\Domain\User\Enum\Genre;
use Core\Domain\User\ObjectValues\Cpf;
use Core\Domain\User\Repository\UserRepositoryInterface;
use Core\Domain\User\Exception\CpfAlreadyInUseException;
use Core\Domain\User\Exception\CpfInvalidException;

class CreateUserUseCase
{
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    /**
     * @throws NotificationException
     * @throws CpfInvalidException
     * @throws \Exception
     */
    public function __invoke(CreateUserInputDto $input): CreateUserOutputDto
    {
        $this->cpfAlreadyInUse($input->cpf);

        $user = new User(
            firstName: $input->firstName,
            lastName: $input->lastName,
            email: $input->email,
            birthday: new \DateTime($input->birthday),
            cpf: new Cpf($input->cpf),
            genre: Genre::from($input->genre),
        );

        $result = $this->repository->insert($user);

        return $this->createUserOutputDto($result);
    }

    /**
     * @throws CpfAlreadyInUseException
     */
    private function cpfAlreadyInUse(string $cpf): void
    {
        $onlyDigits = preg_replace('/[^0-9]/', '', $cpf);
        if ($this->repository->existCpf($onlyDigits)) {
            throw CpfAlreadyInUseException::itemInUse($onlyDigits);
        }
    }

    private function createUserOutputDto(User $entity): CreateUserOutputDto
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
