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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->foreignId('value_tag_id')->nullable()->constrained('post_tags_catalog')->onDelete('set null');
            $table->foreignId('emotion_tag_id')->nullable()->constrained('post_tags_catalog')->onDelete('set null');
            $table->string('category_tag', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
