<?php

namespace App\Http\Requests\v1\Common;

use App\Http\Requests\AppFormRequest;

class CommonFollowRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "page_id" => "required|exists:pages,id",
        ];
    }
}
