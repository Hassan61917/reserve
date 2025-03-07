<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\WalletTransactionResource;
use App\Models\WalletTransaction;
use App\ModelServices\Financial\WalletTransactionService;
use Illuminate\Http\JsonResponse;

class AdminWalletTransactionController extends Controller
{
    protected string $resource = WalletTransactionResource::class;

    public function __construct(
        private WalletTransactionService $transactionService
    )
    {
    }

    public function index(): JsonResponse
    {
        $transactions = $this->transactionService->getAll();
        return $this->ok($this->paginate($transactions));
    }

    public function show(WalletTransaction $transaction): JsonResponse
    {
        $transaction->load("wallet");
        return $this->ok($transaction);
    }

    public function destroy(WalletTransaction $transaction): JsonResponse
    {
        $transaction->delete();
        return $this->deleted();
    }
}
