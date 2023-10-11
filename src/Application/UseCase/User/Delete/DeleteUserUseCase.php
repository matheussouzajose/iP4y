<?php

namespace Core\Application\UseCase\User\Delete;

use Core\Domain\User\Repository\UserRepositoryInterface;

class DeleteUserUseCase
{
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteUserInputDto $input): bool
    {
        return $this->repository->delete($input->id);
    }
}
