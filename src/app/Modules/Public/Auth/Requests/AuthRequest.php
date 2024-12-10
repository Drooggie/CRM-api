<?php

namespace App\Modules\Public\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            "first_name" => "sometimes|string:225",
            "last_name" => "sometimes|string:255",
            "email" => "required|email|unique",
            "phone_number" => "sometimes|phone:INTERNATIONAL|unique",
            "password" => "required",
            "status" => "sometimes|int",
        ];
    }
}
