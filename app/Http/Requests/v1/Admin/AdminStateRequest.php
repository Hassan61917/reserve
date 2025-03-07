<?php

namespace App\Http\Requests\v1\Admin;

use App\Http\Requests\AppFormRequest;

class AdminStateRequest extends AppFormRequest
{
    protected ?string $withSlug = "name";

    public function rules(): array
    {
        return [
            "name" => "required|string",
        ];
    }
}
