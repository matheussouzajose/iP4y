<?php

namespace Tests\Unit\Application\UseCase\User;

use Core\Application\UseCase\User\Update\UpdateUserInputDto;
use Core\Application\UseCase\User\Update\UpdateUserUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Exception\CpfInvalidException;
use Core\Domain\User\Repository\UserRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\Fixtures\UserFixtures;
use Tests\Mocks\UserMock;
use Tests\TestCase;

class UpdateUseCaseUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     * @throws CpfInvalidException
     * @throws BindingResolutionException
     */
    public function test_update_success()
    {
        $repository = \Mockery::spy(\stdClass::class, UserRepositoryInterface::class);
        $repository->shouldReceive('findById')->andReturn(UserMock::make());
        $repository->shouldReceive('update')->andReturn(UserMock::make());

        $useCase = new UpdateUserUseCase(repository: $repository);
        $result = ($useCase)($this->mockInputDto());

        $this->assertEquals(UserFixtures::MATHEUS_ID, $result->id);
        $this->assertEquals(UserFixtures::MATHEUS_FIRST_NAME, $result->firstName);
        $this->assertEquals(UserFixtures::MATHEUS_LAST_NAME, $result->lastName);
        $this->assertEquals(UserFixtures::MATHEUS_EMAIL, $result->email);
        $this->assertEquals(UserFixtures::MATHEUS_BIRTHDAY, $result->birthday);
        $this->assertEquals(UserFixtures::MATHEUS_CPF, $result->cpf);
        $this->assertEquals(UserFixtures::MATHEUS_GENRE, $result->genre);
    }

    private function mockInputDto(): UpdateUserInputDto
    {
        return \Mockery::spy(\stdClass::class, UpdateUserInputDto::class, [UserFixtures::MATHEUS_ID]);
    }
}
