<?php

namespace App\Http\Requests\Register;

use App\Rules\birthDate\ValidDateOfBirth;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name'=>['required','string','min:3','max:255', 'regex:/^[a-zA-Z\-_]+$/'],
            'last_name'=>['required','string','min:3','max:255', 'regex:/^[a-zA-Z\-]+$/'],
            'date_of_birth'=>['required','date','before:'.now()->subYears(18)->format('Y-m-d')],
            'email'=>['required','email'],
            'password'=>['required','string','confirmed',
                         'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!$#%]).{8,15}$/'],
            'postal_code' => ['required', 'string', 'max:20','regex:/^\d{5}(?:-\d{4})?$/'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'ip_address' => ['nullable,ip'],

        ];

    }

    public function messages()
    {
        return [
            'first_name.regex' => 'The first name may only contain letters.',
            'last_name.regex' => 'The last name may only contain letters.',
            'date_of_birth'=> 'The date of birth field must be a date before 2006-06-20 / above 18',
            'password.regex' => 'The password may contain at least one  lowercase letter,one uppercase letter, one number, and one special character . and the length must be between 8 and 15 characters..',
            'postal_code.regex' => 'the postal_code must be like 12356 or 45879-6598'

        ];
    }

    public function trim()
    {
        request()->merge([
            'first_name' => trim($this->first_name),
            'last_name' =>trim($this->last_name),
        ]);
    }
}
