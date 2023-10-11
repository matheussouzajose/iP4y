<?php

namespace Tests\Integration\Ui\Api\Controllers\User;

use App\Models\User;
use Core\Application\UseCase\User\Paginate\PaginateUserUseCase;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Core\Ui\Api\Controllers\User\PaginateUserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class PaginateUseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_paginate_success()
    {
        User::factory(30)->create();

        $controller = $this->createController();
        $request = $this->createRequest();
        $response = ($controller)($request);

        $this->assertCount(15, $response->items());
        $this->assertEquals(30, $response->total());
    }

    private function createRequest(): Request
    {
        $request = new Request();
        $request->headers->set('content-type', 'application/json');

        return $request;
    }

    private function createController(): PaginateUserController
    {
        $repository = new UserRepository(
            model: new User()
        );

        $useCase = new PaginateUserUseCase(
            repository: $repository
        );

        return new PaginateUserController(
            useCase: $useCase
        );
    }
}
