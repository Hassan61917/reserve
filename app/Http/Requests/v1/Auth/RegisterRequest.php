<?php

namespace App\Http\Requests\v1\Auth;

class RegisterRequest extends LoginRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string'],
        ];
    }
}
