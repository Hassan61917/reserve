<?php

namespace App\ModelServices\Financial;

use App\Enums\TransactionType;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Utils\CodeGenerator\ICodeGenerator;
use Illuminate\Database\Eloquent\Builder;

class WalletTransactionService
{
    public function __construct(
        private ICodeGenerator $codeGenerator,
    )
    {
    }

    public function getAll(): Builder
    {
        return WalletTransaction::query()->with('wallet');
    }

    public function getTransactionsFor(User $user): Builder
    {
        return WalletTransaction::query()
            ->whereHas("wallet", fn($query) => $query->where("wallet_id", $user->wallet->id));
    }

    public function deposit(User $user, int $amount): WalletTransaction
    {
        return $this->make($user, $amount, TransactionType::Deposit);
    }

    public function withdraw(User $user, int $amount): WalletTransaction
    {
        return $this->make($user, $amount, TransactionType::Withdraw);
    }

    public function transfer(User $user, string $walletNumber, int $amount): WalletTransaction
    {
        return $this->make($user, $amount, TransactionType::Transfer, $walletNumber);
    }

    public function makeTemporary(User $user, int $amount, TransactionType $type, ?string $walletNumber = null): WalletTransaction
    {
        return $this->make($user, $amount, $type, $walletNumber, true);
    }

    private function make(User $user, int $amount, TransactionType $type, ?string $walletNumber = null, bool $temporary = false): WalletTransaction
    {
        $wallet = $user->wallet;
        $walletBalance = $wallet->balance;
        $data = [
            "type" => $type->value,
            "amount" => $amount,
            "wallet_number" => $walletNumber,
            "before_balance" => $walletBalance,
            "after_balance" => $walletBalance + ($type == TransactionType::Deposit ? $amount : -$amount),
            "code" => $this->codeGenerator->generate(10),
            "temporary" => $temporary
        ];
        return $wallet->transactions()->create($data);
    }
}
