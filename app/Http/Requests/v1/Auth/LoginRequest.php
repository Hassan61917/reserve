<?php

namespace App\Http\Requests\v1\Auth;

use App\Http\Requests\AppFormRequest;

class LoginRequest extends AppFormRequest
{

    public function authorize(): bool
    {
        return !auth()->check();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string'],
        ];
    }
}
