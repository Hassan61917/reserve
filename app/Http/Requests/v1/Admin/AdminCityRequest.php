<?php

namespace App\Http\Requests\v1\Admin;

use App\Http\Requests\AppFormRequest;

class AdminCityRequest extends AppFormRequest
{
    protected ?string $withSlug = "name";

    public function rules(): array
    {
        return [
            "state_id" => "required|integer|exists:states,id",
            "name" => "required|string",
        ];
    }
}
