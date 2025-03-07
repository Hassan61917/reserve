<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Admin\AdminWalletTransactionRequest;
use App\Http\Resources\v1\WalletResource;
use App\Http\Resources\v1\WalletTransactionResource;
use App\Models\Wallet;
use App\ModelServices\Financial\WalletService;
use Illuminate\Http\JsonResponse;

class AdminWalletController extends Controller
{
    protected string $resource = WalletResource::class;

    public function __construct(
        private WalletService $walletService
    )
    {
    }

    public function index(): JsonResponse
    {
        $wallets = $this->walletService->getAll()->withCount("transactions");
        return $this->ok($this->paginate($wallets));
    }

    public function show(Wallet $wallet): JsonResponse
    {
        $wallet->load("transactions")->loadCount("transactions");
        return $this->ok($wallet);
    }

    public function block(Wallet $user): JsonResponse
    {
        $wallet = $this->walletService->block($user);
        return $this->ok($wallet);
    }

    public function unblock(Wallet $user): JsonResponse
    {
        $wallet = $this->walletService->unblock($user);
        return $this->ok($wallet);
    }

    public function deposit(Wallet $wallet, AdminWalletTransactionRequest $request): JsonResponse
    {
        if ($this->isSameWallet($wallet)) {
            return $this->error(403, "deposit can not be done");
        }
        $data = $request->validated();
        $transaction = $this->walletService->deposit($wallet, $data["amount"]);
        $transaction->load("wallet");
        return $this->ok(null, WalletTransactionResource::make($transaction));
    }

    public function withdraw(Wallet $wallet, AdminWalletTransactionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $transaction = $this->walletService->withdraw($wallet, $data["amount"]);
        $transaction->load("wallet");
        return $this->ok(null, WalletTransactionResource::make($transaction));
    }

    public function transfer(Wallet $wallet, Wallet $destination, AdminWalletTransactionRequest $request): JsonResponse
    {
        if ($this->isSameWallet($wallet, $destination)) {
            return $this->error(403, "transfer can not be done");
        }
        $data = $request->validated();
        $transaction = $this->walletService->transfer($wallet, $destination, $data["amount"]);
        $transaction->load("wallet");
        return $this->ok(null, WalletTransactionResource::make($transaction));
    }

    public function destroy(Wallet $wallet): JsonResponse
    {
        $wallet->delete();
        return $this->deleted();
    }

    private function isSameWallet(Wallet $wallet, ?Wallet $target = null): bool
    {
        $target = $target ?: $this->authUser()->wallet;
        return $target->is($wallet);
    }
}
