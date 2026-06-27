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
        Schema::create('official_comunications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('title', 255);
            $table->enum('category', ['Urgente', 'Información General', 'Aviso de Evento', 'Modificación de Calendario']);
            $table->string('adjective_emotion', 100)->nullable();
            $table->text('introduction');
            $table->json('key_points');
            $table->text('closure');
            $table->boolean('requires_signature')->default(false);
            $table->string('signature_path', 255)->nullable();
            $table->enum('status', ['borrador', 'emitido'])->default('emitido');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('official_comunications');
    }
};
