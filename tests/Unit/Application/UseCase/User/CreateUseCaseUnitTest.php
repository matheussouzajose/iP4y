<?php

namespace Tests\Unit\Application\UseCase\User;

use Core\Application\UseCase\User\Create\CreateUserInputDto;
use Core\Application\UseCase\User\Create\CreateUserUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Exception\CpfAlreadyInUseException;
use Core\Domain\User\Exception\CpfInvalidException;
use Core\Domain\User\Repository\UserRepositoryInterface;
use Tests\Fixtures\UserFixtures;
use Tests\Mocks\UserMock;
use Tests\TestCase;

class CreateUseCaseUnitTest extends TestCase
{
    /**
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function test_throws_error_when_cpf_already_exists()
    {
        $this->expectExceptionObject(new CpfAlreadyInUseException('123456', 422));

        $repository = \Mockery::spy(\stdClass::class, UserRepositoryInterface::class);
        $repository
            ->shouldReceive('existCpf')
            ->andThrow(CpfAlreadyInUseException::itemInUse('123456'));

        (new CreateUserUseCase(repository: $repository))($this->mockInputDto());
    }

    /**
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function test_create_success()
    {
        $repository = \Mockery::spy(\stdClass::class, UserRepositoryInterface::class);
        $repository
            ->shouldReceive('insert')
            ->andReturn(UserMock::make());

        $result = (new CreateUserUseCase(repository: $repository))($this->mockInputDto());

        $this->assertEquals(UserFixtures::MATHEUS_ID, $result->id);
        $this->assertEquals(UserFixtures::MATHEUS_FIRST_NAME, $result->firstName);
        $this->assertEquals(UserFixtures::MATHEUS_LAST_NAME, $result->lastName);
        $this->assertEquals(UserFixtures::MATHEUS_EMAIL, $result->email);
        $this->assertEquals(UserFixtures::MATHEUS_BIRTHDAY, $result->birthday);
        $this->assertEquals(UserFixtures::MATHEUS_CPF, $result->cpf);
        $this->assertEquals(UserFixtures::MATHEUS_GENRE, $result->genre);
    }

    private function mockInputDto(): CreateUserInputDto
    {
        return \Mockery::spy(\stdClass::class, CreateUserInputDto::class, [
            UserFixtures::MATHEUS_FIRST_NAME,
            UserFixtures::MATHEUS_LAST_NAME,
            UserFixtures::MATHEUS_EMAIL,
            UserFixtures::MATHEUS_BIRTHDAY,
            UserFixtures::MATHEUS_CPF,
            UserFixtures::MATHEUS_GENRE
        ]);
    }
}
