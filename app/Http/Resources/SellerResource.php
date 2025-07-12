<?php

namespace App\Http\Resources;

use App\Models\Property;
use App\Models\User;
use App\Models\Seller;
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
        $user = User::where("id", $this->user_id)->first();
        return [
            "seller_data" => User::where('id', $this->user_id)->get(),
            "password" => $user->password,
            'newPass' => $request->newPass,
            'confirmPassword' => $request->confirmPassword,
            "company_name" => $this->company_name,
            "about_company" => $this->about_company,
            "logo" => $this->logo,
            "personal_id_image" => $this->personal_id_image,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "own_properties" => PropertyResource::collection($this->properties),
        ];
    }
}
