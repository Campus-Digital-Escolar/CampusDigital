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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('grade', 5);
            $table->string('section', 5);
            $table->foreignId('educational_level_id')->constrained('educational_levels')->onDelete('restrict');
            $table->foreignId('school_year_id')->constrained('school_years')->onDelete('restrict');
            $table->foreignId('tutor_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->timestamps();

            $table->index(['educational_level_id', 'tutor_id'], 'idx_groups_tutor');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
