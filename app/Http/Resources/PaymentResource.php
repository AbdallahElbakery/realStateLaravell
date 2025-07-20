<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Property;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $property = Property::where('id', $this->property_id)->first();
        return [
            "id" => $this->id,
            "payment_id" => $this->payment_id,
            "property_id" => $this->property_id,
            "property" => $property->name,
            "quantity" => $this->quantity,
            "amount" => $this->amount,
            // "currency" => $this->currency,
            "payer_name" => $this->payer_name,
            "payment_status" => $this->payment_status,
            "payer_email" => $this->payer_email,
            "payment_method" => $this->payment_method,
            "date" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
