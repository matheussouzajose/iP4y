<?php

namespace Tests\Unit\Application\UseCase\User;

use Core\Application\UseCase\User\List\ListUserInputDto;
use Core\Application\UseCase\User\List\ListUserUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Repository\UserRepositoryInterface;
use Tests\Fixtures\UserFixtures;
use Tests\Mocks\UserMock;
use Tests\TestCase;

class ListUseCaseUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     */
    public function test_list_success()
    {
        $repository = \Mockery::spy(UserRepositoryInterface::class);
        $repository->shouldReceive('findById')->andReturn(UserMock::make());

        $useCase = new ListUserUseCase(repository: $repository);
        $result = ($useCase)($this->mockInputDto());

        $this->assertEquals(UserFixtures::MATHEUS_ID, $result->id);
        $this->assertEquals(UserFixtures::MATHEUS_FIRST_NAME, $result->firstName);
        $this->assertEquals(UserFixtures::MATHEUS_LAST_NAME, $result->lastName);
        $this->assertEquals(UserFixtures::MATHEUS_EMAIL, $result->email);
        $this->assertEquals(UserFixtures::MATHEUS_BIRTHDAY, $result->birthday);
        $this->assertEquals(UserFixtures::MATHEUS_CPF, $result->cpf);
        $this->assertEquals(UserFixtures::MATHEUS_GENRE, $result->genre);
    }

    private function mockInputDto(): ListUserInputDto
    {
        return \Mockery::spy(ListUserInputDto::class, [UserFixtures::MATHEUS_ID]);
    }
}
