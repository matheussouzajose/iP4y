<?php

namespace Tests\Integration\Application\UseCase\User;

use App\Models\User;
use Core\Application\UseCase\User\Paginate\PaginateUserInputDto;
use Core\Application\UseCase\User\Paginate\PaginateUserUseCase;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class PaginateUseCaseTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new UserRepository(
            model: new User()
        );

        parent::setUp();
    }

    public function test_paginate_success()
    {
        User::factory()->count(10)->create();
        User::factory()->user()->create();

        $useCase = new PaginateUserUseCase(
            repository: $this->repository
        );

        $input = new PaginateUserInputDto(
            filter: UserFixtures::MATHEUS_FIRST_NAME
        );

        $result = ($useCase)($input);

        $this->assertCount(1, $result->items());

    }

    public function test_paginate_page_and_total_page_success()
    {
        User::factory()->count(30)->create();

        $useCase = new PaginateUserUseCase(
            repository: $this->repository
        );

        $input = new PaginateUserInputDto();

        $result = ($useCase)($input);
        $this->assertCount(15, $result->items());
        $this->assertEquals(30, $result->total());

        $input = new PaginateUserInputDto(
            page: 2,
            totalPerPage: 5
        );

        $resultPage = ($useCase)($input);
        $this->assertEquals(2, $resultPage->currentPage());
        $this->assertCount(5, $resultPage->items());


    }
}
