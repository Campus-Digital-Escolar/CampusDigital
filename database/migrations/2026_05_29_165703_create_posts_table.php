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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('gallery_id')->nullable()->constrained('galleries')->onDelete('set null');
            $table->string('title', 255);
            $table->text('body');
            $table->foreignId('value_tag_id')->nullable()->constrained('post_tags_catalog')->onDelete('set null');
            $table->foreignId('emotion_tag_id')->nullable()->constrained('post_tags_catalog')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
