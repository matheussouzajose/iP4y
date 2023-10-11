<?php

namespace Tests\Integration\Application\UseCase\User;

use App\Models\User;
use Core\Application\UseCase\User\Update\UpdateUserInputDto;
use Core\Application\UseCase\User\Update\UpdateUserUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Exception\CpfInvalidException;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class UpdateUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepository $repository;

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
    public function test_update_success()
    {
        User::factory()->user()->create();

        $useCase = new UpdateUserUseCase(
            repository: $this->repository
        );

        $input = new UpdateUserInputDto(
            id: UserFixtures::MATHEUS_ID,
            firstName: 'João',
            lastName: 'Paulo',
            email: UserFixtures::MATHEUS_EMAIL,
            birthday: UserFixtures::MATHEUS_BIRTHDAY,
            cpf: UserFixtures::MATHEUS_CPF,
            genre: UserFixtures::MATHEUS_GENRE
        );

        $result = ($useCase)($input);

        $this->assertDatabaseCount('users', 1);
        $this->assertNotEmpty($result->id);
        $this->assertEquals('João', $result->firstName);
        $this->assertNotEmpty('Paulo', $result->lastName);
    }
}
