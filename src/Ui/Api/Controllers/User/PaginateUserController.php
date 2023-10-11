<?php

namespace Core\Ui\Api\Controllers\User;

use Core\Application\UseCase\User\Paginate\PaginateUserInputDto;
use Core\Application\UseCase\User\Paginate\PaginateUserUseCase;
use Core\Domain\Shared\Repository\PaginationInterface;
use Illuminate\Http\Request;

class PaginateUserController
{
    public function __construct(protected PaginateUserUseCase $useCase)
    {
    }

    public function __invoke(Request $request): PaginationInterface
    {
        return ($this->useCase)($this->createFromRequest($request));
    }

    private function createFromRequest(Request $request): PaginateUserInputDto
    {
        return new PaginateUserInputDto(
            filter: (string) $request->get('filter', ''),
            order: (string) $request->get('order', 'DESC'),
            page: (int) $request->get('page', 1),
            totalPerPage: (int) $request->get('total_page', 15),
        );
    }
}
