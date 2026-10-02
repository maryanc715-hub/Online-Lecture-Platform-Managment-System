<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecture_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lecture_material_id')->constrained('lecture_materials')->cascadeOnDelete();
            $table->timestamp('completed_at')->useCurrent();
            $table->timestamps();
            $table->unique(['student_id', 'lecture_material_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecture_completions');
    }
};
