<?php

namespace App\Http\Requests\v1\Common;

use App\Enums\LikeableModel;
use App\Http\Requests\AppFormRequest;
use App\Rules\EnumRule;

class CommonLikeRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "model" => ["required", new EnumRule(LikeableModel::class)],
            "model_id" => "required",
        ];
    }
}
