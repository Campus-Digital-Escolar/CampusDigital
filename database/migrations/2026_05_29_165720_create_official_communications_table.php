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
        Schema::create('official_communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('title', 255);
            $table->enum('category', ['Urgente', 'Información General', 'Aviso de Evento', 'Modificación de Calendario']);
            $table->foreignId('adjective_emotion_id')->nullable()->constrained('post_tags_catalog')->onDelete('set null');
            $table->text('body');
            $table->boolean('requires_signature')->default(false);
            $table->foreignId('signed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('signature_snapshot_path')->nullable();  // Copia de la firma utilizada al publicar
            $table->enum('status', ['draft', 'published', 'deleted']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('official_communications');
    }
};
