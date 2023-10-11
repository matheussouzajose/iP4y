<?php

namespace Core\Domain\User\Entity;

use Core\Domain\Shared\Entity\Entity;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\Shared\ObjectValues\Uuid;
use Core\Domain\User\Enum\Genre;
use Core\Domain\User\Factory\UserValidatorFactory;
use Core\Domain\User\ObjectValues\Cpf;

class User extends Entity
{
    /**
     * @throws NotificationException
     */
    public function __construct(
        protected string $firstName,
        protected string $lastName,
        protected string $email,
        protected \Datetime $birthday,
        protected Cpf $cpf,
        protected Genre $genre,
        protected ?Uuid $id = null,
        protected ?\DateTime $createdAt = null,
    ) {
        parent::__construct();

        $this->id = $this->id ?? Uuid::random();

        $this->validation();
    }

    /**
     * @throws NotificationException
     */
    private function validation(): void
    {
        UserValidatorFactory::create()->validate($this);

        if ($this->notification->hasErrors()) {
            throw new NotificationException(
                $this->notification->messages('user')
            );
        }
    }

    /**
     * @throws NotificationException
     */
    public function update(
        string $firstName,
        string $lastName,
        string $email,
        Genre $genre,
        Cpf $cpf,
        \DateTime $birthday,
    ): void {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->genre = $genre;
        $this->cpf = $cpf;
        $this->birthday = $birthday;

        $this->validation();
    }

    public function birthday(): string
    {
        return $this->birthday->format('Y-m-d');
    }

    public function cpf(): string
    {
        return (string) $this->cpf;
    }

    public function genreValue(): string
    {
        return $this->genre->value;
    }
}
