<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('instructor_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
            $table->decimal('total_marks', 6, 2)->default(100);
            $table->dateTime('due_date');
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('file_path');
            $table->text('submission_note')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->enum('status', ['submitted', 'late', 'graded'])->default('submitted');
            $table->timestamps();
            $table->unique(['assignment_id', 'student_id']);
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('assignment_submissions')->cascadeOnDelete();
            $table->foreignId('graded_by')->constrained('users')->cascadeOnDelete();
            $table->decimal('marks_obtained', 6, 2);
            $table->text('feedback')->nullable();
            $table->timestamp('graded_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->decimal('completion_percentage', 5, 2)->default(0);
            $table->integer('lectures_completed')->default(0);
            $table->integer('assignments_completed')->default(0);
            $table->decimal('average_grade', 5, 2)->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_progress');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('assignment_submissions');
        Schema::dropIfExists('assignments');
    }
};
