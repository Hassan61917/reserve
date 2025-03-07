<?php

use App\Enums\TransactionType;
use App\Utils\EnumHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("wallet_id")->constrained("wallets");
            $table->enum("type", EnumHelper::toArray(TransactionType::class));
            $table->unsignedInteger("amount");
            $table->unsignedInteger("before_balance");
            $table->unsignedInteger("after_balance");
            $table->string("code")->unique();
            $table->string("wallet_number")->nullable();
            $table->text("description")->nullable();
            $table->boolean("temporary")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
