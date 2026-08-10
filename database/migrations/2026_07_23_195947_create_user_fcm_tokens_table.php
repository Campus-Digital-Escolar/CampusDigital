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
        Schema::create('user_fcm_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('fcm_token')->unique();

            // Meta-información del dispositivo para limpieza o revocación
            $table->string('device_type', 50)->nullable(); // 'web', 'android', 'ios'
            $table->string('device_name')->nullable();     // 'Chrome / Windows', 'iPhone 13'
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_fcm_tokens');
    }
};
