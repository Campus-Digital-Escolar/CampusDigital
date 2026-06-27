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
        Schema::create('sport_team_rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('sport_id')->constrained('sports')->onDelete('cascade');
            $table->foreignId('school_year_id')->constrained('school_years')->onDelete('restrict');
            $table->foreignId('team_id')->constrained('school_teams')->onDelete('cascade');
            $table->integer('games_played')->default(0);
            $table->integer('games_won')->default(0);
            $table->integer('games_drawn')->default(0);
            $table->integer('games_lost')->default(0);
            $table->integer('points')->default(0);
            $table->integer('goals_for')->default(0);
            $table->integer('goals_against')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_team_rankings');
    }
};
