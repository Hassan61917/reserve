<?php

namespace App\Http\Resources\v1;

use App\Http\Resources\AppJsonResource;
use Illuminate\Http\Request;

class WalletResource extends AppJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "balance" => $this->balance,
            "number" => $this->number,
            "blocked" => $this->blocked,
            "transactionsCount" => $this->mergeCount("transactions"),
            "user" => $this->mergeRelation(UserResource::class, "user"),
            "transactions" => $this->mergeRelations(WalletTransactionResource::class, "transactions"),
        ];
    }
}
