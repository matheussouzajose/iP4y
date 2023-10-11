<?php

namespace App\Exceptions;

use Core\Domain\Shared\Exception\EntityValidationException;
use Core\Domain\Shared\Exception\NotFoundException;
use Core\Domain\Shared\Exception\NotificationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use src\Domain\User\Exception\DocumentNumberAlreadyInUseException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $e): \Illuminate\Http\Response|JsonResponse|Response
    {
        if ($e instanceof NotFoundException) {
            return $this->showError($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof EntityValidationException) {
            return $this->showError($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof NotificationException) {
            return $this->showError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } // ok => HTTP_INTERNAL_SERVER_ERROR

        if ($e instanceof DocumentNumberAlreadyInUseException) {
            return $this->showError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::render($request, $e);
    }

    private function showError(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $statusCode);
    }
}
