<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentProgress;
use App\Models\User;
use Illuminate\Http\Request;

class StudentProgressController extends Controller
{
    public function index(Request $request)
    {
        $courseIds = Course::where('instructor_id', auth()->id())->pluck('id');

        $students = User::whereHas('role', fn ($q) => $q->where('name', 'student'))
            ->whereHas('progress', fn ($q) => $q->whereIn('course_id', $courseIds))
            ->with(['progress' => fn ($q) => $q->whereIn('course_id', $courseIds)->with('course')])
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            }))
            ->paginate(15)
            ->withQueryString()
            ->through(function ($student) use ($courseIds) {
                $student->avg_completion = $student->progress->avg('completion_percentage') ?? 0;
                return $student;
            });

        return view('instructor.progress.index', compact('students'));
    }

    public function show(User $student)
    {
        $courseIds = Course::where('instructor_id', auth()->id())->pluck('id');

        $progress = StudentProgress::where('student_id', $student->id)
            ->whereIn('course_id', $courseIds)
            ->with('course')
            ->get();

        $courses = Course::where('instructor_id', auth()->id())->get();

        return view('instructor.progress.show', compact('student', 'progress', 'courses'));
    }
}
