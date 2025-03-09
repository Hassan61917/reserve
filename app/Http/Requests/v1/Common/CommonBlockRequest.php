<?php

namespace App\Http\Requests\v1\Common;

use App\Http\Requests\AppFormRequest;

class CommonBlockRequest extends AppFormRequest
{
    function rules(): array
    {
        return [
            "block_id" => "required|exists:users,id",
            "until" => "nullable",
        ];
    }
}
