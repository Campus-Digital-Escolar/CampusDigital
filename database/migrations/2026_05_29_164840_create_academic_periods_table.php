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
        Schema::create('academic_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_year_id')->constrained('school_years')->onDelete('cascade');
            $table->foreignId('educational_level_id')->constrained('educational_levels')->onDelete('cascade');
            $table->foreignId('period_type_id')->constrained('period_types')->onDelete('cascade');
            $table->string('name', 100);
            $table->unsignedTinyInteger('order')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_periods');
    }
};
