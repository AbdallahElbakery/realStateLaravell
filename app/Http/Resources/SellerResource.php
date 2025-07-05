<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user_id" => $this->user_id,
            "company_name" => $this->company_name,
            "logo" => $this->logo,
            "personal_id_image" => $this->personal_id_image,
            "status" => $this->status,
            "created_at" => $this->created_at,
        ];
    }
}
