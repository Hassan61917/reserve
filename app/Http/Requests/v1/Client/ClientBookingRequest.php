<?php

namespace App\Http\Requests\v1\Client;

use App\Http\Requests\AppFormRequest;

class ClientBookingRequest extends AppFormRequest
{
    protected array $unset = ["item_id"];
    public function rules(): array
    {
        return [
            "item_id" => "required:exists:service_items,id",
            "hour" => "required|between:1,23",
            "date" => "required|date_format:Y-m-d",
        ];
    }
}
