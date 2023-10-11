<?php

namespace Tests\Unit\Domain\User\Entity;

use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\User\Entity\User;
use Core\Domain\User\Enum\Genre;
use Core\Domain\User\ObjectValues\Cpf;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class UserUnitTest extends TestCase
{
    /**
     * @dataProvider invalidData
     * @throws NotificationException
     */
    public function test_it_throws_when_given_an_invalid_data(
        $firstName,
        $lastName,
        $email,
        $messageExpected
    ): void {
        $this->expectExceptionObject(new NotificationException($messageExpected));

        new User(
            firstName: $firstName,
            lastName: $lastName,
            email: $email,
            birthday: new \DateTime(UserFixtures::MATHEUS_BIRTHDAY),
            cpf: new Cpf(UserFixtures::MATHEUS_CPF),
            genre: Genre::from(UserFixtures::MATHEUS_GENRE),
            id: new Uuid(UserFixtures::MATHEUS_ID),
            createdAt: new \DateTime(UserFixtures::MATHEUS_CREATED_AT)
        );
    }

    public static function invalidData(): array
    {
        return [
            [
                '',
                UserFixtures::MATHEUS_LAST_NAME,
                UserFixtures::MATHEUS_EMAIL,
                'user: The FirstName is required',
            ],
            [
                UserFixtures::MATHEUS_FIRST_NAME,
                '',
                UserFixtures::MATHEUS_EMAIL,
                'user: The LastName is required',
            ],
            [
                UserFixtures::MATHEUS_FIRST_NAME,
                UserFixtures::MATHEUS_LAST_NAME,
                '',
                'user: The Email is required',
            ],
        ];
    }

    /**
     * @throws NotificationException
     */
    public function test_new_user_success()
    {
        $user = $this->createUser();

        $this->assertEquals(UserFixtures::MATHEUS_FIRST_NAME, $user->firstName);
        $this->assertEquals(UserFixtures::MATHEUS_LAST_NAME, $user->lastName);
        $this->assertEquals(UserFixtures::MATHEUS_EMAIL, $user->email);
        $this->assertEquals(UserFixtures::MATHEUS_BIRTHDAY, $user->birthday->format('Y-m-d'));
        $this->assertEquals(UserFixtures::MATHEUS_CPF, (string) $user->cpf);
        $this->assertEquals(UserFixtures::MATHEUS_GENRE, $user->genre->value);
        $this->assertEquals(UserFixtures::MATHEUS_ID, $user->id());
        $this->assertEquals(UserFixtures::MATHEUS_CREATED_AT, $user->createdAt());
    }

    /**
     * @throws NotificationException
     */
    private function createUser(): User
    {
        return new User(
            firstName: UserFixtures::MATHEUS_FIRST_NAME,
            lastName: UserFixtures::MATHEUS_LAST_NAME,
            email: UserFixtures::MATHEUS_EMAIL,
            birthday: new \DateTime(UserFixtures::MATHEUS_BIRTHDAY),
            cpf: new Cpf(UserFixtures::MATHEUS_CPF),
            genre: Genre::from(UserFixtures::MATHEUS_GENRE),
            id: new Uuid(UserFixtures::MATHEUS_ID),
            createdAt: new \DateTime(UserFixtures::MATHEUS_CREATED_AT)
        );
    }

    /**
     * @throws NotificationException
     */
    public function test_update_user_success()
    {
        $user = $this->createUser();
        $user->update(
            firstName: 'Jhuana',
            lastName: 'Lorraine',
            email: 'jhuana.lorraine@mail.com',
            genre: Genre::FEMALE,
            cpf: new Cpf('10660997070'),
            birthday: new \DateTime('2020-01-01')
        );

        $this->assertEquals('Jhuana', $user->firstName);
        $this->assertEquals('Lorraine', $user->lastName);
        $this->assertEquals('jhuana.lorraine@mail.com', $user->email);
    }
}
