<?php

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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->string("code")->unique();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("category_id")->nullable()->constrained("categories");
            $table->foreignId("client_id")->nullable()->constrained("users");
            $table->foreignId('service_id')->nullable()->constrained("services");
            $table->foreignId("item_id")->nullable()->constrained("service_items");
            $table->unsignedInteger("limit")->default(1);
            $table->unsignedInteger("amount")->default(0);
            $table->unsignedInteger("percent")->default(0);
            $table->unsignedInteger("total_balance")->default(0);
            $table->unsignedInteger("max_amount")->nullable();
            $table->timestamp("expire_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
