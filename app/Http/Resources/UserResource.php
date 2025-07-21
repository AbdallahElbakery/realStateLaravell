<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'role' => $this->role,
            'date' => $this->created_at,
            'updated' => $this->updated_at,
            'address' => [
                'address_id' => $this->address->id,
                'city' => $this->address->city,
                'country' => $this->address->country,
            ],
            // 'address_id' => $this->address->id,
        ];
    }
}
