<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\AppFormRequest;

class UserServiceItemRequest extends AppFormRequest
{
    protected ?string $withSlug = "name";

    public function rules(): array
    {
        return [
            "name" => "required|string",
            "price" => "required|numeric",
            "description" => "required|string",
            "duration" => "nullable|numeric",
            "hidden" => "nullable|boolean",
            "available" => "nullable|boolean",
        ];
    }
}
