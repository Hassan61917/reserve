<?php

namespace App\Http\Requests\v1\Client;

use App\Http\Requests\AppFormRequest;

class ClientQuestionRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "service_id" => "required|exists:services,id",
            "item_id" => "nullable|exists:service_items,id",
            "question" => "required|string",
        ];
    }
}

