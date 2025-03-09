<?php

namespace App\Http\Requests\v1\Common;

use App\Http\Requests\AppFormRequest;

class CommonAdsOrderRequest extends AppFormRequest
{
    protected array $unset = ["ads_id"];

    public function rules(): array
    {
        return [
            "ads_id" => "required|exists:ads,id",
            "link" => "required",
            "image" => "required"
        ];
    }
}
