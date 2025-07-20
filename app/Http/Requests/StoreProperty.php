<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProperty extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|max:255",
            "description" => "required",
            "citynum" => "required",
            "price" => "required",
            "purpose" => "required",
            "area" => "required",
            "bedrooms" => "required",
            "bathrooms" => "required",
            "category_id" => "required|exists:categories,id",
            "seller_id" => "required|exists:sellers,user_id",
            "city" => "required",
            "country" => "required",
            "payment_method" => "required",
            // "location" => "required",
            // "image" => "required",
            // "address_id" => "required|exists:addresses,id",
        ];


    }
    public function messages(): array
    {
        return [
            "seller_id" => "this seller is not found"
        ];


    }

}
