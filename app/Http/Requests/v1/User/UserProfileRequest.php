<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\AppFormRequest;

class UserProfileRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "state_id" => "required|exists:states,id",
            "city_id" => "required|exists:cities,id",
            "name" => "required|string",
            "phone" => "required|digits:11",
            "avatar" => "nullable|string",
        ];
    }
}
