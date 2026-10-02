<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $assignments = Assignment::with('course')
            ->where('instructor_id', auth()->id())
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhereHas('course', fn ($c) => $c->where('title', 'like', "%{$request->search}%"));
            }))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('instructor.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $courses = Course::where('instructor_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('instructor.assignments.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'total_marks' => 'required|integer|min:1',
            'due_date' => 'required|date|after:now',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['instructor_id'] = auth()->id();
        $validated['status'] = 'active';
        $validated['sort_order'] = $validated['sort_order']
            ?? Assignment::max('sort_order') + 1;

        $assignment = Assignment::create($validated);

        ActivityLog::record('assignment.created', "Created assignment: {$assignment->title}", $assignment);

        return redirect()->route('instructor.assignments.show', $assignment)
            ->with('success', 'Assignment created successfully.');
    }

    public function show(Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        $assignment->load(['course', 'submissions.student', 'submissions.grade']);

        return view('instructor.assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        $courses = Course::where('instructor_id', auth()->id())
            ->orderBy('title')
            ->get();

        return view('instructor.assignments.edit', compact('assignment', 'courses'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'course_id' => 'required|exists:courses,id',
            'total_marks' => 'required|integer|min:1',
            'due_date' => 'required|date',
            'status' => 'required|in:active,closed',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $assignment->update($validated);

        ActivityLog::record('assignment.updated', "Updated assignment: {$assignment->title}", $assignment);

        return redirect()->route('instructor.assignments.show', $assignment)
            ->with('success', 'Assignment updated successfully.');
    }

    public function destroy(Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        $title = $assignment->title;
        $assignment->delete();

        ActivityLog::record('assignment.deleted', "Deleted assignment: {$title}");

        return redirect()->route('instructor.assignments.index')
            ->with('success', 'Assignment deleted successfully.');
    }

    public function submissions(Assignment $assignment)
    {
        $this->authorizeAssignment($assignment);

        $assignment->load(['submissions.student', 'submissions.grade', 'course']);

        return view('instructor.assignments.submissions', compact('assignment'));
    }

    public function grade(Request $request, AssignmentSubmission $submission)
    {
        $assignment = $submission->assignment;

        if ($assignment->instructor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'marks_obtained' => 'required|numeric|min:0|max:' . $assignment->total_marks,
            'feedback' => 'nullable|string|max:1000',
        ]);

        Grade::updateOrCreate(
            ['submission_id' => $submission->id],
            [
                'marks_obtained' => $validated['marks_obtained'],
                'feedback' => $validated['feedback'] ?? null,
                'graded_by' => auth()->id(),
                'graded_at' => now(),
            ]
        );

        $submission->update(['status' => 'graded']);

        Notification::notify(
            (string) $submission->student_id,
            'grade',
            'Assignment graded',
            "Your submission for \"{$assignment->title}\" was graded ({$validated['marks_obtained']}/{$assignment->total_marks})."
        );

        ActivityLog::record(
            'submission.graded',
            "Graded submission by {$submission->student->name} for: {$assignment->title}",
            $submission
        );

        return back()->with('success', 'Submission graded successfully.');
    }

    public function downloadSubmission(AssignmentSubmission $submission)
    {
        $this->authorizeAssignment($submission->assignment);

        if (! $submission->file_path || ! Storage::disk('public')->exists($submission->file_path)) {
            abort(404, 'File not found.');
        }

        $extension = pathinfo($submission->file_path, PATHINFO_EXTENSION);
        $name = Str::slug($submission->assignment->title . ' ' . ($submission->student->name ?? 'student'), '_') . '.' . $extension;

        return Storage::disk('public')->download($submission->file_path, $name);
    }

    private function authorizeAssignment(Assignment $assignment): void
    {
        if ($assignment->instructor_id !== auth()->id()) {
            abort(403);
        }
    }
}
