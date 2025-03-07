<?php

namespace App\Http\Requests\v1\Admin;

use App\Http\Requests\AppFormRequest;

class AdminUserRequest extends AppFormRequest
{
    protected array $unset = ["role_id"];
    public function rules(): array
    {
        return [
            'role_id' => ['required', 'exists:roles,id'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string'],
        ];
    }
}
