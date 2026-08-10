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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Destinatario
            $table->enum('type', ['official_comunication', 'internal_comunication', 'grades', 'sports', 'event', 'post', 'honor_roll']);
            $table->string('title', 150);
            $table->text('body');
            // Datos adicionales payload (JSON) para redirección en frontend (ej: { "url": "/communications/12", "action": "open_modal" })
            $table->json('data')->nullable();
            $table->nullableMorphs('notifiable');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'read_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
