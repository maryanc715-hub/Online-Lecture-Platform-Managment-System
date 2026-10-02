<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\LectureMaterial;
use App\Models\LectureModule;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LectureMaterialController extends Controller
{
    public function index(Request $request)
    {
        $materials = LectureMaterial::with(['course', 'module'])
            ->where('instructor_id', auth()->id())
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhereHas('course', fn ($c) => $c->where('title', 'like', "%{$request->search}%"));
            }))
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('instructor.lectures.index', compact('materials'));
    }

    public function create(Request $request)
    {
        $courses = Course::where('instructor_id', auth()->id())
            ->orderBy('title')
            ->get();

        $modules = $this->getModules();

        return view('instructor.lectures.create', [
            'courses' => $courses,
            'modules' => $modules,
            'selectedCourseId' => $request->course_id,
            'selectedModuleId' => $request->module_id,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'type' => 'required|in:document,video,notes,other',
            'file' => 'nullable|file|max:102400',
            'video_url' => 'nullable|url|max:500',
            'category' => 'nullable|string|max:100',
            'visibility' => 'required|in:public,private',
            'course_id' => 'required|exists:courses,id',
            'module_id' => 'nullable|exists:lecture_modules,id',
        ]);

        $validated['instructor_id'] = auth()->id();
        $validated['module_id'] = $this->resolveModule($validated['course_id'], $validated['module_id'] ?? null);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('lectures', $filename, 'public');
            $validated['file_path'] = 'lectures/' . $filename;
        }

        $material = LectureMaterial::create($validated);

        Course::find($validated['course_id'])?->students->each(function ($student) use ($material) {
            Notification::notify(
                (string) $student->id,
                'lecture',
                'New lecture available',
                "New lecture: {$material->title}"
            );
        });

        ActivityLog::record('lecture.created', "Created lecture material: {$material->title}", $material);

        return redirect()->route('instructor.lectures.show', $material)
            ->with('success', 'Lecture material uploaded successfully.');
    }

    public function show(LectureMaterial $lecture)
    {
        $this->authorizeMaterial($lecture);

        $lecture->load(['course', 'module']);

        return view('instructor.lectures.show', compact('lecture'));
    }

    public function edit(LectureMaterial $lecture)
    {
        $this->authorizeMaterial($lecture);

        $courses = Course::where('instructor_id', auth()->id())
            ->orderBy('title')
            ->get();

        $modules = $this->getModules();

        return view('instructor.lectures.edit', compact('lecture', 'courses', 'modules'));
    }

    public function update(Request $request, LectureMaterial $lecture)
    {
        $this->authorizeMaterial($lecture);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'type' => 'required|in:document,video,notes,other',
            'file' => 'nullable|file|max:102400',
            'video_url' => 'nullable|url|max:500',
            'category' => 'nullable|string|max:100',
            'visibility' => 'required|in:public,private',
            'course_id' => 'required|exists:courses,id',
            'module_id' => 'nullable|exists:lecture_modules,id',
        ]);

        $validated['module_id'] = $this->resolveModule($validated['course_id'], $validated['module_id'] ?? null);

        if ($request->hasFile('file')) {
            if ($lecture->file_path && \Storage::disk('public')->exists($lecture->file_path)) {
                \Storage::disk('public')->delete($lecture->file_path);
            }

            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('lectures', $filename, 'public');
            $validated['file_path'] = 'lectures/' . $filename;
        }

        $lecture->update($validated);

        ActivityLog::record('lecture.updated', "Updated lecture material: {$lecture->title}", $lecture);

        return redirect()->route('instructor.lectures.show', $lecture)
            ->with('success', 'Lecture material updated successfully.');
    }

    public function destroy(LectureMaterial $lecture)
    {
        $this->authorizeMaterial($lecture);

        if ($lecture->file_path && \Storage::disk('public')->exists($lecture->file_path)) {
            \Storage::disk('public')->delete($lecture->file_path);
        }

        $title = $lecture->title;
        $lecture->delete();

        ActivityLog::record('lecture.deleted', "Deleted lecture material: {$title}");

        return redirect()->route('instructor.lectures.index')
            ->with('success', 'Lecture material deleted successfully.');
    }

    private function authorizeMaterial(LectureMaterial $material): void
    {
        if ($material->instructor_id !== auth()->id()) {
            abort(403);
        }
    }

    private function getModules()
    {
        $courseIds = Course::where('instructor_id', auth()->id())->pluck('id');

        return LectureModule::with('course')
            ->whereIn('course_id', $courseIds)
            ->orderBy('course_id')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    private function resolveModule(int $courseId, ?int $moduleId): ?int
    {
        if (! $moduleId) {
            return null;
        }

        return LectureModule::where('id', $moduleId)
            ->where('course_id', $courseId)
            ->value('id');
    }
}
