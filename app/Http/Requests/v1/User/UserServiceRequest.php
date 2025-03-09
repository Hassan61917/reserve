<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\AppFormRequest;

class UserServiceRequest extends AppFormRequest
{
    protected ?string $withSlug = "name";

    public function rules(): array
    {
        return [
            "category_id" => ["required", "numeric", "exists:categories,id"],
            "name" => ["required", "string", "max:35"],
            "description" => ["required", "string", "max:255"],
        ];
    }
}
