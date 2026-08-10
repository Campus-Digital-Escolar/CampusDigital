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
        Schema::create('internal_communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('category', ['meeting', 'general_announcement']);
            $table->enum('status', ['draft', 'published', 'scheduled', 'rescheduled', 'completed', 'cancelled', 'deleted']);
            $table->string('title');
            $table->text('description');
            $table->dateTime('event_date')->nullable();
            $table->string('location')->nullable();
            $table->boolean('send_reminder')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internal_communications');
    }
};
