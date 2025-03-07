<?php

namespace App\ModelServices\Financial;

use App\Enums\TransactionType;
use App\Events\WalletBalanceWasUpdated;
use App\Exceptions\ModelException;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Builder;

class WalletService
{
    public function __construct(
        private WalletTransactionService $transactionService
    )
    {
    }

    public function getAll(array $relations = []): Builder
    {
        return Wallet::query()->with($relations);
    }

    public function updatePassword(User $user, string $password): Wallet
    {
        $wallet = $user->wallet;
        $wallet->update(['password' => $password]);
        return $wallet;
    }

    public function block(Wallet $wallet): Wallet
    {
        return $this->updateBlockStatus($wallet, true);
    }

    public function unblock(Wallet $wallet): Wallet
    {
        return $this->updateBlockStatus($wallet, false);
    }

    public function deposit(Wallet $wallet, int $amount, bool $temporary = false): WalletTransaction
    {
        return $this->updateBalance(TransactionType::Deposit, $wallet, $amount, null, $temporary);
    }

    public function withdraw(Wallet $wallet, int $amount, bool $temporary = false): WalletTransaction
    {
        return $this->updateBalance(TransactionType::Withdraw, $wallet, $amount, null, $temporary);
    }

    public function transfer(Wallet $from, Wallet $destination, int $amount, bool $temporary = false): WalletTransaction
    {
        return $this->updateBalance(TransactionType::Transfer, $from, $amount, $destination, $temporary);
    }

    private function updateBlockStatus(Wallet $wallet, bool $blocked): Wallet
    {
        $wallet->update(['blocked' => $blocked]);
        return $wallet;
    }

    private function updateBalance(TransactionType $type, Wallet $wallet, int $amount, ?Wallet $destination = null, bool $temporary = false): ?WalletTransaction
    {
        $this->checkTransaction($type, $wallet, $amount);
        $this->updateWalletBalance($type, $wallet, $amount, $destination);
        if (!$temporary) {
            $transaction = $this->makeTransaction($type, $wallet, $amount, $destination);
            $this->dispatchEvents($wallet, $transaction, $destination);
            return $transaction;
        }
        return null;
    }
    private function checkTransaction(TransactionType $type, Wallet $wallet, int $amount): void
    {
        $isDeposit = $type == TransactionType::Deposit;
        if (!$isDeposit && $amount > $wallet->balance) {
            throw new ModelException("not enough balance");
        }
        if (!$isDeposit && $wallet->blocked) {
            throw new ModelException("your wallet is blocked");
        }
    }
    private function makeTransaction(TransactionType $type, Wallet $wallet, int $amount, ?Wallet $destination = null): WalletTransaction
    {
        $user = $wallet->user;
        return match ($type) {
            TransactionType::Deposit => $this->transactionService->deposit($user, $amount),
            TransactionType::Withdraw => $this->transactionService->withdraw($user, $amount),
            TransactionType::Transfer => $this->transactionService->transfer($user, $destination->number, $amount)
        };
    }
    private function updateWalletBalance(TransactionType $type, Wallet $wallet, int $amount, ?Wallet $destination): void
    {
        if ($type == TransactionType::Deposit) {
            $wallet->increment('balance', $amount);
        } elseif ($type == TransactionType::Withdraw) {
            $wallet->decrement('balance', $amount);
        } elseif ($type == TransactionType::Transfer && $destination) {
            $wallet->decrement('balance', $amount);
            $destination->increment('balance', $amount);
        }
    }
    private function dispatchEvents(Wallet $wallet, WalletTransaction $transaction, ?Wallet $destination): void
    {
        WalletBalanceWasUpdated::dispatch($wallet, $transaction);
        if ($destination) {
            WalletBalanceWasUpdated::dispatch($destination, $transaction);
        }
    }
}
