<?php

namespace App\Http\Requests\Login;

use App\Rules\Auth\PasswordMatchRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'=>['required','exists:users,email'],
            'password'=>['required','string',new PasswordMatchRule($this->email)]
        ];
    }
}
