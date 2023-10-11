<?php

namespace Tests\Unit\Application\UseCase\User;

use Core\Application\UseCase\User\Paginate\PaginateUserInputDto;
use Core\Application\UseCase\User\Paginate\PaginateUserUseCase;
use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Domain\User\Repository\UserRepositoryInterface;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use Tests\TestCase;

class PaginateUseCaseUnitTest extends TestCase
{
    public function test_paginate_success()
    {
        $repository = \Mockery::spy(\stdClass::class, UserRepositoryInterface::class);
        $repository
            ->shouldReceive('paginate')
            ->andReturn($this->mockPagination());

        $useCase = new PaginateUserUseCase(repository: $repository);
        $result = ($useCase)($this->mockInputDto());

        $this->assertInstanceOf(PaginationInterface::class, $result);
    }

    private function mockInputDto(): PaginateUserInputDto
    {
        return \Mockery::spy(\stdClass::class, PaginateUserInputDto::class, ['filter', 'desc', 1, 15]);
    }

    protected function mockPagination(array $items = []): MockInterface|PaginationInterface|LegacyMockInterface|\stdClass
    {
        $mockPagination = \Mockery::spy(\stdClass::class, PaginationInterface::class);
        $mockPagination->shouldReceive('items')->andReturn($items);
        $mockPagination->shouldReceive('total')->andReturn(0);
        $mockPagination->shouldReceive('currentPage')->andReturn(0);
        $mockPagination->shouldReceive('firstPage')->andReturn(0);
        $mockPagination->shouldReceive('lastPage')->andReturn(0);
        $mockPagination->shouldReceive('perPage')->andReturn(0);
        $mockPagination->shouldReceive('to')->andReturn(0);
        $mockPagination->shouldReceive('from')->andReturn(0);

        return $mockPagination;
    }
}
