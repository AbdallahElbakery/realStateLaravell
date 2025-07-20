<?php

namespace App\Http\Resources;

use App\Models\Property;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "seller" => Seller::where('user_id', $this->user_id)->first()->user_id,
            "user" => User::where("id", $this->user_id)->first()->name,
            "property" => Property::where("id", $this->property_id)->first()->name,
            "suggested_price" => $this->suggested_price,
            "status" => $this->status,
            "created" => $this->created_at,
            "updated" => $this->updated_at,
        ];
    }
}
