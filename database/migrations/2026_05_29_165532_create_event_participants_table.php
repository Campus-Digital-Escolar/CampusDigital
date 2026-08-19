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
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_event_id')->constrained('sport_events')->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('cascade');
            $table->foreignId('school_team_id')->nullable()->constrained('school_teams')->onDelete('cascade');
            $table->string('external_participant_name')->nullable(); // Para competidores o equipos externos
            $table->string('external_institution')->nullable();       // Nombre de la escuela o club visitante
            $table->string('result_value', 50)->default('0');
            $table->boolean('is_winner')->default(false);
            $table->string('result_position')->nullable(); // Para saber si quedó 1°, 2°, etc. (útil en atletismo/natación)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};
