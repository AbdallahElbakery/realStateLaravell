<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Image;
use App\Models\Address;
use App\Models\Category;
use App\Models\Seller;
class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->seller_id);
        $seller = Seller::where('user_id', $this->seller_id)->first();
        return [
            'id'=> $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "citynum" => $this->citynum,
            "purpose" => $this->purpose,
            "area" => $this->area,
            "bedrooms" => $this->bedrooms,
            "bathrooms" => $this->bathrooms,
            "date" => $this->created_at,
            "category" => Category::where('id', $this->category_id)->value('category_name'),
            "seller" => [
                "user_id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "phone" => $user->phone,
                "role" => $user->role,
                "photo" => $user->photo,
                'company_name' => $seller->company_name,
                'logo' => $seller->logo,
                'status' => $seller->status,
                "created_at" => $user->created_at,
            ],
            "address_id"=>$this->address_id,
            // "seller_user_id"=>$this->seller_id,
            "country" => Address::where('id', $this->address_id)->value('country'),
            "city" => Address::where('id', $this->address_id)->value("city"),
            "location" => Address::where('id', $this->address_id)->value("full_address"),
            "image" => $this->image,
            "images" => $this->images->pluck('image'),
        ];
    }
}
