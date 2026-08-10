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
        Schema::create('official_communication_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('official_communication_id')->constrained('official_communications', indexName: 'fk_comm_attachments_comm_id')->onDelete('cascade');
            $table->string('file_path', 255);
            $table->string('file_name', 255);
            $table->string('mime_type', 255)->nullable(); // ej. 'application/pdf', 'image/png'
            $table->string('file_size', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('official_communication_attachments');
    }
};
