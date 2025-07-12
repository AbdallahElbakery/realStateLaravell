<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSellerPass extends FormRequest
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
            'current_password' => ['required'],
            "newPass" => ['required', 'min:8'],
            "confirmPassword" => ['required', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Current password is required.',
            // 'current_password.current_password' => 'The current password is incorrect.',
            'password.required' => 'New password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ];
    }
}
