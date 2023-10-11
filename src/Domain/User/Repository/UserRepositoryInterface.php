<?php

namespace Core\Domain\User\Repository;

use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Domain\User\Entity\User;

interface UserRepositoryInterface
{
    public function insert(User $entity): User;

    public function findById(string $id): User;

    public function paginate(string $filter = '', string $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface;

    public function update(User $entity): User;

    public function delete(string $id): bool;

    public function existCpf(string $cpf): bool;
}
