<?php

namespace Core\Application\UseCase\User\Create;

class CreateUserInputDto
{
    public function __construct(
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $birthday,
        public string $cpf,
        public string $genre
    ) {
    }
}
