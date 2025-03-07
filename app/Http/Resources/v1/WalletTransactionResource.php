<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class WalletTransactionResource extends AppJsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "type" => $this->type,
            "amount" => $this->amount,
            "before_balance" => $this->before_balance,
            "after_balance" => $this->after_balance,
            "code" => $this->code,
            "description" => $this->description,
            "wallet_number" => $this->mergeWhen($this->wallet_number != null, $this->wallet_number),
            "wallet" => $this->mergeRelation(WalletResource::class, "wallet")
        ];
    }
}
