<?php

namespace Tests\Integration\Ui\Api\Controllers\User;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Core\Application\UseCase\User\Create\CreateUserOutputDto;
use Core\Application\UseCase\User\Create\CreateUserUseCase;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Exception\CpfInvalidException;
use Core\Infrastructure\Persistence\Eloquent\UserRepository;
use Core\Ui\Api\Controllers\User\CreateUserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Tests\Fixtures\UserFixtures;
use Tests\TestCase;

class CreateUseControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function test_create_success()
    {
        $request = $this->createRequest();
        $controller = $this->createController();
        $response = ($controller)($request);

        $this->assertInstanceOf(CreateUserOutputDto::class, $response);
        $this->assertNotEmpty($response->id);
        $this->assertEquals(UserFixtures::MATHEUS_CPF, $response->cpf);
    }

    private function createRequest(): StoreUserRequest
    {
        $request = new StoreUserRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(
            new ParameterBag([
                'first_name' => UserFixtures::MATHEUS_FIRST_NAME,
                'last_name' => UserFixtures::MATHEUS_LAST_NAME,
                'email' => UserFixtures::MATHEUS_EMAIL,
                'cpf' => UserFixtures::MATHEUS_CPF,
                'genre' => UserFixtures::MATHEUS_GENRE,
                'birthday' => UserFixtures::MATHEUS_BIRTHDAY
            ])
        );

        return $request;
    }

    private function createController(): CreateUserController
    {
        $repository = new UserRepository(
            model: new User()
        );

        $useCase = new CreateUserUseCase(
            repository: $repository
        );

        return new CreateUserController(
            useCase: $useCase
        );
    }
}
