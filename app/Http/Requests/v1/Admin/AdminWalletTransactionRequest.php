<?php

namespace App\Http\Requests\v1\Admin;

use App\Http\Requests\AppFormRequest;

class AdminWalletTransactionRequest extends AppFormRequest
{
    public function rules(): array
    {
        return [
            "amount" => "required|integer",
        ];
    }
}
