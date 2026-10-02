<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssignmentSubmissionController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $assignments = Assignment::whereIn('course_id', $student->courses()->pluck('courses.id'))
            ->with(['course', 'submissions' => fn ($q) => $q->where('student_id', $student->id)])
            ->orderBy('due_date', 'desc')
            ->get();

        return view('student.assignments.index', ['assignments' => $assignments]);
    }

    public function show(Assignment $assignment)
    {
        $student = auth()->user();

        if (!$student->courses()->where('courses.id', $assignment->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        $assignment->load(['course', 'instructor']);

        $existingSubmission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->with('grade')
            ->first();

        return view('student.assignments.show', [
            'assignment' => $assignment,
            'existingSubmission' => $existingSubmission,
        ]);
    }

    public function store(Request $request, Assignment $assignment)
    {
        $student = auth()->user();

        if (!$student->courses()->where('courses.id', $assignment->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        $validated = $request->validate([
            'submission_file' => 'required|file|max:20480|mimes:pdf,doc,docx,zip,rar',
            'submission_note' => 'nullable|string|max:2000',
        ]);

        $existing = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existing) {
            return back()->withErrors(['submission_file' => 'You have already submitted this assignment.']);
        }

        $filePath = $request->file('submission_file')->store('submissions/' . $student->id, 'public');

        AssignmentSubmission::create([
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'file_path' => $filePath,
            'submission_note' => $request->input('submission_note'),
            'submitted_at' => now(),
            'status' => 'submitted',
        ]);

        Notification::notify(
            (string) $assignment->instructor_id,
            'submission',
            'New assignment submission',
            "{$student->name} submitted \"{$assignment->title}\"."
        );

        return back()->with('success', 'Assignment submitted successfully.');
    }

    public function download(Assignment $assignment)
    {
        $student = auth()->user();

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        if (! $submission->file_path || ! Storage::disk('public')->exists($submission->file_path)) {
            abort(404, 'File not found.');
        }

        $extension = pathinfo($submission->file_path, PATHINFO_EXTENSION);
        $name = Str::slug($assignment->title . ' ' . $student->name, '_') . '.' . $extension;

        return Storage::disk('public')->download($submission->file_path, $name);
    }

    public function grades()
    {
        $student = auth()->user();

        $gradedSubmissions = AssignmentSubmission::where('student_id', $student->id)
            ->where('status', 'graded')
            ->with(['grade', 'assignment.course'])
            ->latest('submitted_at')
            ->get();

        return view('student.grades.index', ['gradedSubmissions' => $gradedSubmissions]);
    }
}
