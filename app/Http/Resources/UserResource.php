<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'document_number' => $this->email,
            'genre' => $this->email,
            'birthday' => Carbon::make($this->birthday)->format('Y-m-d'),
//            'created_at' => Carbon::make($this->createdAt)->format('Y-m-d'),
        ];
    }
}
