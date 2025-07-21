<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class adminProfile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "phone"=> $this->phone,
            "role"=> $this->role,
            "photo"=> $this->photo,
            "created_at"=> $this->created_at,
            "updated_at"=> $this->updated_at,
            "address_id"=> $this->address_id,
            "city"=>Address::where("id",$this->address_id)->first()->city,
            "country"=>Address::where("id",$this->address_id)->first()->country,
        ];
    }
}
