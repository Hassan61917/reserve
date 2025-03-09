<?php

use App\Enums\ServiceStatus;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("category_id")->constrained("categories");
            $table->string("name");
            $table->string("slug");
            $table->text("description");
            $table->enum("status", EnumHelper::toArray(ServiceStatus::class))->default(ServiceStatus::Draft);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
