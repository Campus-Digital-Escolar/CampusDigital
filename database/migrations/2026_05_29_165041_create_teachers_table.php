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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('lastname');
            $table->foreignId('job_position_id')->nullable()->constrained('job_positions')->onDelete('set null');
            $table->enum('title', ['Dir.', 'Lic.', 'Prof.', 'Ing.', 'Dr.', 'Mtr.']);
            $table->string('profession', 150);
            $table->string('photo_path', 255)->nullable();
            $table->enum('status', ['active', 'inactive', 'licensed', 'intern', 'provisinal']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
