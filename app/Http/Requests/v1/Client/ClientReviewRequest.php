<?php

namespace App\Http\Requests\v1\Client;

use App\Http\Requests\AppFormRequest;

class ClientReviewRequest extends AppFormRequest
{
    protected array $unset = ["booking_id"];

    public function rules(): array
    {
        return [
            "booking_id" => "required|exists:bookings,id",
            "rate" => "required|integer|between:1,5",
            "body" => "nullable|string",
        ];
    }
}
