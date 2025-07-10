<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProperty extends FormRequest
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
            "description" => "required|min:50",
            "price" => "required|numeric|min:1",
            "citynum" => "required",
            "purpose" => "required",
            "area" => "required|integer|min:1",
            "bedrooms" => "required|integer|min:0",
            "bathrooms" => "required|integer|min:0",
            "created_at" => "required",
            "category_id" => "required|exists:categories,id",
            "seller_id" => "required",
            "city" => "required",
            "country" => "required",
            "location" => "required",
            "image" => "required",
        ];
    }
}
