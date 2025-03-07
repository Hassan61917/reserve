<?php

namespace Database\Factories;

use App\Enums\TransactionType;
use App\Models\Wallet;
use App\Utils\CodeGenerator\ICodeGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletTransaction>
 */
class WalletTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "wallet_id" => Wallet::factory(),
            "type" => TransactionType::Deposit->value,
            "amount" => 100,
            "before_balance" => 0,
            "after_balance" => 100,
            "code" => $this->getCode(),
            "wallet_number" => null,
            "description" => null,
            "temporary" => false,
        ];
    }
    private function getCode(): int
    {
        return app(ICodeGenerator::class)->generate(10);
    }
}
