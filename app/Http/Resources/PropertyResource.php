<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "city" => $this->city,
            "purpose" => $this->purpose,
            "area" => $this->area,
            "bedrooms" => $this->bedrooms,
            "created_at" => $this->created_at,
            "category_id" => $this->category_id,
            "seller_id" => $this->seller_id,
            "address_id" => $this->address_id,
        ];
    }
}
