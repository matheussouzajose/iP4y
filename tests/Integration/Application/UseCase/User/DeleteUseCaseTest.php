<?php

namespace Tests\Integration\Application\UseCase\User;

use App\Models\User;
use Core\Application\UseCase\User\Delete\DeleteUserInputDto;
use Core\Application\UseCase\User\Delete\DeleteUserUseCase;
use Core\Domain\Shared\Exception\NotFoundException;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class DeleteUseCaseTest extends TestCase
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

    public function test_throws_error_when_not_found()
    {
        $this->expectExceptionObject(new NotFoundException("O item " . UserFixtures::MATHEUS_ID . " não foi encontrado.", 403));

        $useCase = new DeleteUserUseCase(
            repository: $this->repository
        );

        $input = new DeleteUserInputDto(
            id: UserFixtures::MATHEUS_ID,
        );

        ($useCase)($input);
    }

    public function test_delete_success()
    {
        User::factory()->user()->create();
        $this->assertDatabaseCount('users', 1);

        $useCase = new DeleteUserUseCase(
            repository: $this->repository
        );

        $input = new DeleteUserInputDto(
            id: UserFixtures::MATHEUS_ID,
        );

        ($useCase)($input);

        $this->assertDatabaseCount('users', 0);
    }
}
