<?php

namespace App\Http\Requests\v1\Admin;

use App\Http\Requests\AppFormRequest;

class AdminBanRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "reason" => "required|string",
            "duration" => "nullable|integer|between:1,30",
            "started_at" => "nullable",
        ];
    }
}
