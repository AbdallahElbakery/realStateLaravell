<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnProperty extends FormRequest
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
            // "image" => "required",
            "name" => "required|max:255",
            "description" => "required",
            "citynum" => "required",
            "price" => "required",
            // "country" => "required",
            // "city" => "required",
            // "location" => "required",
            "area" => "required",
            "bedrooms" => "required",
            "bathrooms" => "required",
            "purpose" => "required",
            "category_id" => "required|exists:categories,id",
            "address_id" => "required|exists:addresses,id",
        ];
    }
}
