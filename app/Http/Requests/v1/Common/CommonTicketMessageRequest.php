<?php

namespace App\Http\Requests\v1\Common;

use App\Http\Requests\AppFormRequest;

class CommonTicketMessageRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "body" => "required|string",
            "message_id" => "nullable|exists:ticket_messages,id",
        ];
    }
}
