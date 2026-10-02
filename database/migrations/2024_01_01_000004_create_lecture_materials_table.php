<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecture_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['pdf', 'doc', 'ppt', 'video_link', 'other'])->default('pdf');
            $table->string('file_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('category')->nullable();
            $table->enum('visibility', ['visible', 'hidden'])->default('visible');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecture_materials');
    }
};
