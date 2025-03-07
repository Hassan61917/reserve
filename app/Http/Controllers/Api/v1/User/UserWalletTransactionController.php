<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\AuthUserController;
use App\Http\Resources\v1\WalletTransactionResource;
use App\Models\WalletTransaction;
use App\ModelServices\Financial\WalletTransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserWalletTransactionController extends AuthUserController
{
    protected string $resource = WalletTransactionResource::class;
    protected ?string $ownerRelation = "wallet";
    public function __construct(
        private WalletTransactionService $transactionService
    )
    {
    }

    public function index(): JsonResponse
    {
        $transactions = $this->transactionService->getTransactionsFor($this->authUser());
        return $this->ok($this->paginate($transactions));
    }

    public function show(WalletTransaction $transaction): JsonResponse
    {
        $transaction->load("wallet");
        return $this->ok($transaction);
    }

    public function update(Request $request, WalletTransaction $transaction): JsonResponse
    {
        $data = $request->validate([
            "description" => "required|string",
        ]);
        $transaction->update($data);
        return $this->ok($transaction);
    }
}
