<?php

namespace Core\Infrastructure\Persistence\Eloquent;

use Core\Domain\Shared\Exception\NotFoundException;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Domain\User\Entity\User;
use Core\Domain\User\Enum\Genre;
use Core\Domain\User\Exception\CpfInvalidException;
use Core\Domain\User\ObjectValues\Cpf;
use Core\Domain\User\Repository\UserRepositoryInterface;
use App\Models\User as Model;
use Core\Infrastructure\Persistence\Presenters\PaginationPresenter;
use Illuminate\Contracts\Container\BindingResolutionException;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * @throws BindingResolutionException
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function insert(User $entity): User
    {
        $result = $this->model->create([
            'id' => $entity->id(),
            'first_name' => $entity->firstName,
            'last_name' => $entity->lastName,
            'email' => $entity->email,
            'cpf' => (string)$entity->cpf,
            'birthday' => $entity->birthday,
            'genre' => $entity->genre->value,
        ]);

        return $this->convertObjectToEntity($result);
    }

    /**
     * @throws CpfInvalidException
     * @throws NotFoundException
     * @throws BindingResolutionException
     * @throws NotificationException
     */
    public function findById(string $id): User
    {
        if (! $result = $this->model->find($id)) {
            throw NotFoundException::itemNotFound($id);
        }

        return $this->convertObjectToEntity($result);
    }

    public function paginate(
        string $filter = '',
        string $order = 'DESC',
        int $page = 1,
        int $totalPage = 15
    ): PaginationInterface {
        $result = $this->model->when($filter, function ($query) use ($filter) {
            $query->where('first_name', 'LIKE', "%{$filter}%");
        })
            ->orderBy('first_name', $order)
            ->paginate($totalPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }

    /**
     * @throws BindingResolutionException
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function update(User $entity): User
    {
        $result = $this->model->find($entity->id());
        $result->update([
            'first_name' => $entity->firstName,
            'last_name' => $entity->lastName,
            'email' => $entity->email,
            'cpf' => (string) $entity->cpf,
            'genre' => $entity->genre->value,
            'birthday' => $entity->birthday,
        ]);

        $result->refresh();

        return $this->convertObjectToEntity($result);
    }

    /**
     * @throws NotFoundException
     */
    public function delete(string $id): bool
    {
        if (! $result = $this->model->find($id)) {
            throw NotFoundException::itemNotFound($id);
        }

        return $result->delete();
    }

    public function existCpf(string $cpf): bool
    {
        return $this->model->whereCpf($cpf)->exists();
    }

    /**
     * @throws BindingResolutionException
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    protected function convertObjectToEntity(object $data): User
    {
        return new User(
            firstName: $data->first_name,
            lastName: $data->last_name,
            email: $data->email,
            birthday: $data->birthday,
            cpf: new Cpf($data->cpf),
            genre: Genre::from($data->genre),
            id: new Uuid($data->id),
        );
    }
}
