<?php

namespace Core\Application\UseCase\User\List;

class ListUserInputDto
{
    public function __construct(public string $id)
    {
    }
}
