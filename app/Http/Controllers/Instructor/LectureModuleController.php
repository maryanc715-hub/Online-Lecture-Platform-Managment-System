<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\LectureModule;
use Illuminate\Http\Request;

class LectureModuleController extends Controller
{
    public function index(Request $request)
    {
        $courseIds = Course::where('instructor_id', auth()->id())->pluck('id');

        $modules = LectureModule::with(['course', 'lectureMaterials'])
            ->whereIn('course_id', $courseIds)
            ->when($request->course_id, fn ($q) => $q->where('course_id', $request->course_id))
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhereHas('course', fn ($c) => $c->where('title', 'like', "%{$request->search}%"));
            }))
            ->orderBy('course_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        $courses = Course::where('instructor_id', auth()->id())->orderBy('title')->get();

        return view('instructor.modules.index', compact('modules', 'courses'));
    }

    public function create(Request $request)
    {
        $courses = Course::where('instructor_id', auth()->id())->orderBy('title')->get();

        return view('instructor.modules.create', [
            'courses' => $courses,
            'selectedCourseId' => $request->course_id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $this->authorizeCourse((int) $validated['course_id']);

        $validated['sort_order'] = $validated['sort_order']
            ?? LectureModule::where('course_id', $validated['course_id'])->max('sort_order') + 1;

        $module = LectureModule::create($validated);

        ActivityLog::record('module.created', "Created module {$module->title}", $module);

        return redirect()->route('instructor.modules.show', $module)
            ->with('success', 'Module created successfully.');
    }

    public function show(LectureModule $module)
    {
        $this->authorizeModule($module);

        $module->load(['course', 'lectureMaterials']);

        return view('instructor.modules.show', compact('module'));
    }

    public function edit(LectureModule $module)
    {
        $this->authorizeModule($module);

        $courses = Course::where('instructor_id', auth()->id())->orderBy('title')->get();

        return view('instructor.modules.edit', compact('module', 'courses'));
    }

    public function update(Request $request, LectureModule $module)
    {
        $this->authorizeModule($module);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $this->authorizeCourse((int) $validated['course_id']);

        $module->update($validated);

        ActivityLog::record('module.updated', "Updated module {$module->title}", $module);

        return redirect()->route('instructor.modules.show', $module)
            ->with('success', 'Module updated successfully.');
    }

    public function destroy(LectureModule $module)
    {
        $this->authorizeModule($module);

        $title = $module->title;
        $module->delete();

        ActivityLog::record('module.deleted', "Deleted module {$title}");

        return redirect()->route('instructor.modules.index')
            ->with('success', 'Module deleted successfully.');
    }

    private function authorizeCourse(int $courseId): void
    {
        abort_unless(
            Course::where('id', $courseId)->where('instructor_id', auth()->id())->exists(),
            403
        );
    }

    private function authorizeModule(LectureModule $module): void
    {
        abort_unless($module->course && $module->course->instructor_id === auth()->id(), 403);
    }
}
