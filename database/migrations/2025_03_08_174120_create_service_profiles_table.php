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
        Schema::create('service_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId("service_id")->constrained("services");
            $table->foreignId("state_id")->constrained("states");
            $table->foreignId("city_id")->constrained("cities");
            $table->unsignedInteger("open_at")->nullable();
            $table->unsignedInteger("close_at")->nullable();
            $table->string("phone")->nullable();
            $table->text("address")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_profiles');
    }
};
