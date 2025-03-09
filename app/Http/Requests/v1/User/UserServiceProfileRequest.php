<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\AppFormRequest;

class UserServiceProfileRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "start_hour" => "required|between:0,23",
            "end_hour" => "required|between:0,23",
            "phone" => "required|digits:10",
            "address" => "required",
        ];
    }
}
