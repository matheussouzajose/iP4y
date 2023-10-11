<?php

namespace Tests\Mocks;

use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\User\Entity\User;
use Core\Domain\User\Enum\Genre;
use Core\Domain\User\ObjectValues\Cpf;
use Tests\Fixtures\UserFixtures;

class UserMock
{
    /**
     * @throws NotificationException
     */
    public static function make(): User
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
}
