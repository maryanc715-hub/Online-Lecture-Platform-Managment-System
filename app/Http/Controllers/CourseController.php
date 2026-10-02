<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Notification;
use App\Models\StudentProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::with(['category', 'instructor'])->withCount('students');

        // Instructors only see their own courses
        if (auth()->user()->hasRole('instructor')) {
            $query->where('instructor_id', auth()->id());
        }

        $courses = $query
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->category_id, fn ($q) => $q->where('category_id', $request->category_id))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = CourseCategory::all();

        $view = auth()->user()->hasRole('admin') ? 'admin.courses.index' : 'instructor.courses.index';

        return view($view, compact('courses', 'categories'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        return view('admin.courses.create', [
            'categories' => CourseCategory::all(),
            'instructors' => User::whereHas('role', fn ($q) => $q->where('name', 'instructor'))->get(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:course_categories,id',
            'instructor_id' => 'required|exists:users,id',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:100',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('course-thumbnails', 'public');
        }

        $course = Course::create($validated);

        ActivityLog::record('course.created', "Created course {$course->title}", $course);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        $this->authorizeManage($course);

        $course->load(['category', 'instructor', 'lectureMaterials', 'assignments', 'students']);
        $course->load([
            'lectureModules' => fn ($q) => $q->orderBy('sort_order')->orderBy('id')->with('lectureMaterials'),
        ]);
        $course->loadCount('students');

        $enrolledIds = $course->students->pluck('id');
        $availableStudents = User::whereHas('role', fn ($q) => $q->where('name', 'student'))
            ->whereNotIn('id', $enrolledIds)
            ->orderBy('name')
            ->get();

        $view = auth()->user()->hasRole('admin') ? 'admin.courses.show' : 'instructor.courses.show';

        return view($view, compact('course', 'availableStudents'));
    }

    public function enroll(Request $request, Course $course)
    {
        $this->authorizeManage($course);

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::findOrFail($validated['student_id']);

        if (! $student->hasRole('student')) {
            return back()->withErrors(['student_id' => 'Selected user is not a student.']);
        }

        $course->students()->syncWithoutDetaching([$student->id]);

        StudentProgress::firstOrCreate(
            ['student_id' => $student->id, 'course_id' => $course->id],
            ['completion_percentage' => 0]
        );

        Notification::notify(
            (string) $student->id,
            'enrollment',
            'Course enrollment',
            "You have been enrolled in \"{$course->title}\"."
        );

        ActivityLog::record('enrollment.created', "Enrolled {$student->name} in {$course->title}", $course);

        return back()->with('success', "{$student->name} has been enrolled in {$course->title}.");
    }

    public function unenroll(Request $request, Course $course)
    {
        $this->authorizeManage($course);

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $course->students()->detach($validated['student_id']);

        StudentProgress::where('student_id', $validated['student_id'])
            ->where('course_id', $course->id)
            ->delete();

        ActivityLog::record('enrollment.deleted', "Removed student #{$validated['student_id']} from {$course->title}", $course);

        return back()->with('success', 'Student removed from course.');
    }

    public function edit(Course $course)
    {
        $this->authorizeManage($course);

        return view(auth()->user()->hasRole('admin') ? 'admin.courses.edit' : 'instructor.courses.edit', [
            'course' => $course,
            'categories' => CourseCategory::all(),
            'instructors' => User::whereHas('role', fn ($q) => $q->where('name', 'instructor'))->get(),
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeManage($course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:course_categories,id',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:100',
            'instructor_id' => 'sometimes|exists:users,id',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('course-thumbnails', 'public');
        }

        $course->update($validated);

        ActivityLog::record('course.updated', "Updated course {$course->title}", $course);

        return back()->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->authorizeAdmin();

        $course->delete();

        ActivityLog::record('course.deleted', "Deleted course {$course->title}");

        return back()->with('success', 'Course deleted successfully.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
    }

    private function authorizeManage(Course $course): void
    {
        $user = auth()->user();

        abort_unless($user->hasRole('admin') || $user->hasRole('instructor'), 403);

        if ($user->hasRole('instructor') && $course->instructor_id !== $user->id) {
            abort(403);
        }
    }
}
