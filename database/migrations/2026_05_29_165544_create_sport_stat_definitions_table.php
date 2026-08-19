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
        Schema::create('sport_stat_definitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_id')->constrained('sports')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('code', 20);
            $table->text('description')->nullable();
            $table->enum('data_type', ['conteo', 'tiempo', 'texto']);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['sport_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sport_stat_definitions');
    }
};
