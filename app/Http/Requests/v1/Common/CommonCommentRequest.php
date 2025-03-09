<?php

namespace App\Http\Requests\v1\Common;

use App\Http\Requests\AppFormRequest;

class CommonCommentRequest extends AppFormRequest
{
    protected array $unset = ["post_id"];

    public function rules(): array
    {
        return [
            "post_id" => "required|exists:posts,id",
            "comment" => "required|string",
            "parent_id" => "nullable|exists:comments,id",
        ];
    }
}
