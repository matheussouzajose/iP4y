<?php

namespace Tests\Integration\Ui\Api\Controllers\User;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Core\Application\UseCase\User\Update\UpdateUserOutputDto;
use Core\Application\UseCase\User\Update\UpdateUserUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Exception\CpfInvalidException;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Core\Ui\Api\Controllers\User\UpdateUserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class UpdateUseControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function test_update_success()
    {
        User::factory()->user()->create();

        $request = $this->createRequest();
        $controller = $this->createController();
        $response = ($controller)($request, UserFixtures::MATHEUS_ID);

        $this->assertInstanceOf(UpdateUserOutputDto::class, $response);
        $this->assertNotEmpty($response->id);
        $this->assertEquals('João', $response->firstName);
        $this->assertEquals('Paulo', $response->lastName);
    }

    private function createRequest(): UpdateUserRequest
    {
        $request = new UpdateUserRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(
            new ParameterBag([
                'first_name' => 'João',
                'last_name' => 'Paulo',
                'email' => UserFixtures::MATHEUS_EMAIL,
                'cpf' => UserFixtures::MATHEUS_CPF,
                'genre' => UserFixtures::MATHEUS_GENRE,
                'birthday' => UserFixtures::MATHEUS_BIRTHDAY
            ])
        );

        return $request;
    }

    private function createController(): UpdateUserController
    {
        $repository = new UserRepository(
            model: new User()
        );

        $useCase = new UpdateUserUseCase(
            repository: $repository
        );

        return new UpdateUserController(
            useCase: $useCase
        );
    }
}
