<?php

namespace Tests\Integration\Ui\Api\Controllers\User;

use App\Models\User;
use Core\Application\UseCase\User\Delete\DeleteUserUseCase;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Core\Ui\Api\Controllers\User\DeleteUserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class DeleteUseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_success()
    {
        User::factory()->user()->create();

        $controller = $this->createController();
        $response = ($controller)(UserFixtures::MATHEUS_ID);

        $this->assertTrue($response);
    }

    private function createController(): DeleteUserController
    {
        $repository = new UserRepository(
            model: new User()
        );

        $useCase = new DeleteUserUseCase(
            repository: $repository
        );

        return new DeleteUserController(
            useCase: $useCase
        );
    }
}
