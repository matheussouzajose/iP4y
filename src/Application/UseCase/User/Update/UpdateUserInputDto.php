<?php

namespace Core\Application\UseCase\User\Update;

class UpdateUserInputDto
{
    public function __construct(
        public string $id,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $email = null,
        public ?string $birthday = null,
        public ?string $cpf = null,
        public ?string $genre = null
    ) {
    }
}
