<?php

namespace Tests\Unit\Application\UseCase\User;

use Core\Application\UseCase\User\Delete\DeleteUserInputDto;
use Core\Application\UseCase\User\Delete\DeleteUserUseCase;
use Core\Domain\User\Repository\UserRepositoryInterface;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class DeleteUseCaseUnitTest extends TestCase
{
    public function test_delete_success()
    {
        $repository = \Mockery::spy(\stdClass::class, UserRepositoryInterface::class);
        $repository->shouldReceive('delete')->andReturn(true);

        $useCase = new DeleteUserUseCase(repository: $repository);
        $result = ($useCase)($this->mockInputDto());

        $this->assertTrue($result);
    }

    private function mockInputDto(): DeleteUserInputDto
    {
        return \Mockery::spy(DeleteUserInputDto::class, [UserFixtures::MATHEUS_ID]);
    }
}
