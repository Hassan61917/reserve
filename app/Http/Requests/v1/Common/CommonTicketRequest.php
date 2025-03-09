<?php

namespace App\Http\Requests\v1\Common;

use App\Http\Requests\AppFormRequest;

class CommonTicketRequest extends AppFormRequest
{
    protected array $unset = ["category_id"];

    public function rules(): array
    {
        return [
            "category_id" => "required|exists:ticket_categories,id",
            "title" => "required|string",
            "body" => "required|string",
        ];
    }
}
