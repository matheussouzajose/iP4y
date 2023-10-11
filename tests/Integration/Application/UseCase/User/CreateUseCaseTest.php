<?php

namespace Tests\Integration\Application\UseCase\User;

use App\Models\User;
use Core\Application\UseCase\User\Create\CreateUserInputDto;
use Core\Application\UseCase\User\Create\CreateUserUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Exception\CpfAlreadyInUseException;
use Core\Domain\User\Exception\CpfInvalidException;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class CreateUseCaseTest extends TestCase
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
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function test_throws_error_when_cpf_already_exists()
    {
        $this->expectExceptionObject(new CpfAlreadyInUseException(UserFixtures::MATHEUS_CPF, 422));

        User::factory()->user()->create();

        $useCase = new CreateUserUseCase(
            repository: $this->repository
        );

        $input = new CreateUserInputDto(
            firstName: UserFixtures::MATHEUS_FIRST_NAME,
            lastName: UserFixtures::MATHEUS_LAST_NAME,
            email: UserFixtures::MATHEUS_EMAIL,
            birthday: UserFixtures::MATHEUS_BIRTHDAY,
            cpf: UserFixtures::MATHEUS_CPF,
            genre: UserFixtures::MATHEUS_GENRE
        );

        ($useCase)($input);
    }

    /**
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function test_create_success()
    {
        $useCase = new CreateUserUseCase(
            repository: $this->repository
        );

        $input = new CreateUserInputDto(
            firstName: UserFixtures::MATHEUS_FIRST_NAME,
            lastName: UserFixtures::MATHEUS_LAST_NAME,
            email: UserFixtures::MATHEUS_EMAIL,
            birthday: UserFixtures::MATHEUS_BIRTHDAY,
            cpf: UserFixtures::MATHEUS_CPF,
            genre: UserFixtures::MATHEUS_GENRE
        );

        $result = ($useCase)($input);

        $this->assertDatabaseCount('users', 1);
        $this->assertNotEmpty($result->id);
    }
}
