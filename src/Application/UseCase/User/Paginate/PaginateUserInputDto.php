<?php

namespace Core\Application\UseCase\User\Paginate;

class PaginateUserInputDto
{
    public function __construct(
        public string $filter = '',
        public string $order = 'DESC',
        public int $page = 1,
        public int $totalPerPage = 15,
    ) {
    }
}
