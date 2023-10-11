<?php

namespace App\Http\Adapters;

use App\Http\Resources\DefaultResource;
use Core\Domain\Shared\Repository\PaginationInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ApiAdapter
{
    public function __construct(
        protected PaginationInterface $pagination
    ) {
    }

    public function toJsonPagination(): AnonymousResourceCollection
    {
        return DefaultResource::collection($this->pagination->items())
            ->additional([
                'meta' => [
                    'total' => $this->pagination->total(),
                    'current_page' => $this->pagination->currentPage(),
                    'last_page' => $this->pagination->lastPage(),
                    'first_page' => $this->pagination->firstPage(),
                    'per_page' => $this->pagination->perPage(),
                    'to' => $this->pagination->to(),
                    'from' => $this->pagination->from(),
                ],
            ]);
    }

    public static function toJson(object $data, int $statusCode = 200, array $additional = []): JsonResponse
    {
        return (new DefaultResource($data))
            ->additional($additional)
            ->response()
            ->setStatusCode($statusCode);
    }
}
