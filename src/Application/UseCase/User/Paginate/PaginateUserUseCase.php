<?php

namespace Core\Application\UseCase\User\Paginate;

use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Domain\User\Repository\UserRepositoryInterface;

class PaginateUserUseCase
{
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    public function __invoke(PaginateUserInputDto $input): PaginationInterface
    {
        return $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPerPage,
        );
    }
}
