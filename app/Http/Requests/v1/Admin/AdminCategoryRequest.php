<?php

namespace App\Http\Requests\v1\Admin;

use App\Http\Requests\AppFormRequest;

class AdminCategoryRequest extends AppFormRequest
{
    protected ?string $withSlug = "name";

    public function rules(): array
    {
        return [
            "name" => "required|string",
            "icon" => "nullable|string",
            "parent_id" => "nullable|integer|exists:categories,id",
        ];
    }
}
