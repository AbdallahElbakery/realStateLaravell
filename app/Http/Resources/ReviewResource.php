<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Seller;
use App\Models\User;
class ReviewResource extends JsonResource
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
            "user" => User::find($this->user_id)->name,
            "seller" => User::where('id', $this->seller_id)->first()->name,
            "rating" => $this->rating,
            "comment" => $this->comment,
            "date" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
