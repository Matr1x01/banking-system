<?php

namespace App\Http\Requests;

use App\Enum\UserType;
use Illuminate\Contracts\Validation\Rule;
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
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'email', 'unique:users'],
            'password'=>['required', 'string', 'min:8', 'max:255'],
            'password_confirmation'=>['required', 'string', 'min:8', 'max:255'],
            'account_type'=>['required', 'string', 'in:'.implode(',', UserType::toArray())],
        ];
    } 

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->password !== $this->password_confirmation) {
                $validator->errors()->add('password', 'Password and confirm password does not match');
            }
        });
    }
}
