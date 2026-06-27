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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('gallery_id')->nullable()->constrained('galleries')->onDelete('set null');
            $table->string('title', 255);
            $table->text('description');
            $table->enum('location_type', ['dentro', 'fuera']);
            $table->string('target_grade', 100);
            $table->dateTime('event_date');
            $table->enum('status', ['programado', 'reprogramado', 'cancelado', 'finalizado'])->default('programado');
            $table->integer('reminder_days_before')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
