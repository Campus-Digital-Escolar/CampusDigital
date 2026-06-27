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
        Schema::create('match_stat_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('sport_events')->onDelete('cascade');
            $table->foreignId('participant_id')->constrained('event_participants')->onDelete('cascade');
            $table->foreignId('stat_definition_id')->constrained('sport_stat_definitions')->onDelete('cascade');
            $table->string('value', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_stat_records');
    }
};
