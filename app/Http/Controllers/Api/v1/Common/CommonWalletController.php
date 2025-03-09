<?php

namespace App\Http\Controllers\Api\v1\Common;

use App\Http\Controllers\AuthUserController;
use App\Http\Requests\v1\Common\CommonTransactionRequest;
use App\Http\Resources\v1\TransactionRequestResource;
use App\Http\Resources\v1\WalletResource;
use App\ModelServices\Financial\PaymentService;
use App\ModelServices\Financial\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommonWalletController extends AuthUserController
{
    protected string $resource = WalletResource::class;

    public function __construct(
        private WalletService $walletService,
        private PaymentService $paymentService,
    )
    {
    }

    public function index(): JsonResponse
    {
        $wallet = $this->authUser(["wallet"])->wallet;
        return $this->ok($wallet);
    }

    public function setPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            "password" => "required|string|min:6",
        ]);
        $wallet = $this->walletService->updatePassword($this->authUser(), $data["password"]);
        return $this->ok($wallet);
    }
    public function deposit(CommonTransactionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->authUser();
        $transaction = $this->paymentService->deposit($user, $data);
        $transaction->load("transaction");
        return $this->ok($transaction,TransactionRequestResource::make($transaction));
    }
    public function withdraw(CommonTransactionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->authUser();
        $transaction = $this->paymentService->withdraw($user, $data);
        $transaction->load("transaction");
        return $this->ok($transaction,TransactionRequestResource::make($transaction));
    }
}
