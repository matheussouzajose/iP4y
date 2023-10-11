<?php

namespace Tests\Integration\Infrastructure\Persistence\Eloquent\Repository;

use App\Models\User;
use Core\Domain\Shared\Exception\NotFoundException;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Enum\Genre;
use Core\Domain\User\Exception\CpfInvalidException;
use Core\Domain\User\Repository\UserRepositoryInterface;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixtures\UserFixtures;
use Tests\Mocks\UserMock;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepositoryInterface $repository;

    protected function setUp(): void
    {
        $this->repository = new UserRepository(
            model: new User()
        );

        parent::setUp();
    }

    /**
     * @throws BindingResolutionException
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function test_insert_success()
    {
        $result = $this->repository->insert(UserMock::make());

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'id' => $result->id(),
        ]);
    }

    /**
     * @throws CpfInvalidException
     * @throws NotFoundException
     * @throws BindingResolutionException
     * @throws NotificationException
     */
    public function test_find_by_id_success()
    {
        User::factory()->user()->create();

        $result = $this->repository->findById(UserFixtures::MATHEUS_ID);

        $this->assertEquals(UserFixtures::MATHEUS_ID, $result->id());
    }

    /**
     * @throws CpfInvalidException
     * @throws NotFoundException
     * @throws BindingResolutionException
     * @throws NotificationException
     */
    public function test_throws_when_id_not_found()
    {
        $this->expectExceptionObject(new NotFoundException(UserFixtures::MATHEUS_ID, 403));

        $this->repository->findById(UserFixtures::MATHEUS_ID);
    }

    public function test_paginate_filter_success()
    {
        User::factory()->count(10)->create();
        User::factory()->user()->create();

        $result = $this->repository->paginate(
            filter: UserFixtures::MATHEUS_FIRST_NAME
        );

        $this->assertCount(1, $result->items());
    }

    public function test_paginate_page_and_total_page_success()
    {
        User::factory()->count(30)->create();

        $result = $this->repository->paginate();
        $this->assertCount(15, $result->items());
        $this->assertEquals(30, $result->total());

        $result = $this->repository->paginate(totalPage: 10);
        $this->assertCount(10, $result->items());

        $result = $this->repository->paginate(page: 2, totalPage: 5);
        $this->assertEquals(2, $result->currentPage());
    }

    /**
     * @throws BindingResolutionException
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function test_update_success()
    {
        User::factory()->user()->create();

        $entity = UserMock::make();
        $entity->update(
            firstName: 'Jõao',
            lastName: 'Paulo',
            email: 'joao.paulo@mail.com',
            genre: Genre::MALE,
            cpf: $entity->cpf,
            birthday: new \DateTime()
        );

        $result = $this->repository->update($entity);

        $this->assertEquals('Jõao', $result->firstName);
        $this->assertEquals('Paulo', $result->lastName);
        $this->assertEquals('joao.paulo@mail.com', $result->email);
    }

    public function test_delete_success()
    {
        User::factory()->user()->create();
        $this->assertDatabaseCount('users', 1);

        $this->repository->delete(UserFixtures::MATHEUS_ID);
        $this->assertDatabaseCount('users', 0);
    }
}
