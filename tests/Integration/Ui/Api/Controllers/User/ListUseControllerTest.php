<?php

namespace Tests\Integration\Ui\Api\Controllers\User;

use App\Models\User;
use Core\Application\UseCase\User\List\ListUserUseCase;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Core\Ui\Api\Controllers\User\ListUserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class ListUseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_success()
    {
        User::factory()->user()->create();

        $controller = $this->createController();
        $response = ($controller)(UserFixtures::MATHEUS_ID);

        $this->assertEquals(UserFixtures::MATHEUS_ID, $response->id);
    }

    private function createController(): ListUserController
    {
        $repository = new UserRepository(
            model: new User()
        );

        $useCase = new ListUserUseCase(
            repository: $repository
        );

        return new ListUserController(
            useCase: $useCase
        );
    }
}
