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
        Schema::create('grading_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_period_id')->constrained('academic_periods')->onDelete('cascade');
            $table->foreignId('grading_period_type_id')->constrained('grading_period_types')->onDelete('cascade');
            $table->string('name');
            $table->unsignedTinyInteger('order')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('weight', 5,2)->nullable();
            $table->enum('status', ['pending', 'inProgress', 'closed'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_periods');
    }
};
