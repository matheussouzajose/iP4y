<?php

namespace App\Http\Controllers;

use App\Factories\Controllers\User\CreateUserControllerFactory;
use App\Factories\Controllers\User\DeleteUserControllerFactory;
use App\Factories\Controllers\User\ListUserControllerFactory;
use App\Factories\Controllers\User\PaginateUserControllerFactory;
use App\Factories\Controllers\User\UpdateUserControllerFactory;
use App\Http\Adapters\ApiAdapter;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Core\Domain\Shared\Exception\NotificationException;
use Core\Domain\User\Exception\CpfInvalidException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @throws CpfInvalidException
     * @throws NotificationException
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $controller = CreateUserControllerFactory::make();
        $response = ($controller)($request);

        return ApiAdapter::toJson($response, Response::HTTP_CREATED);
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $controller = PaginateUserControllerFactory::make();
        $response = ($controller)($request);

        return (new ApiAdapter($response))->toJsonPagination();
    }

    public function show(string $id): JsonResponse
    {
        $controller = ListUserControllerFactory::make();
        $response = ($controller)($id);

        return ApiAdapter::toJson($response, Response::HTTP_OK);
    }

    /**
     * @throws BindingResolutionException
     * @throws NotificationException
     * @throws CpfInvalidException
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $controller = UpdateUserControllerFactory::make();
        $response = ($controller)($request, $id);

        return ApiAdapter::toJson($response, Response::HTTP_OK);
    }

    public function destroy(string $id): \Illuminate\Http\Response
    {
        $controller = DeleteUserControllerFactory::make();
        ($controller)($id);

        return response()->noContent();
    }
}
