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
        Schema::create('report_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId("category_id")->constrained("report_categories");
            $table->unsignedInteger("count")->default(10);
            $table->unsignedInteger("duration")->default(24);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_rules');
    }
};
