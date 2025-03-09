<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\AppFormRequest;

class UserServiceDayOffRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "service_item_id" => "nullable|exists:services_items,id",
            "in_week" => "nullable|numeric",
            "in_month" => "nullable|numeric",
            "date" => "nullable",
        ];
    }
}
