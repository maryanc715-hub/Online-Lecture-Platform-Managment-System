<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\LectureCompletion;
use App\Models\LectureMaterial;
use App\Models\LiveSession;
use App\Models\Notification;
use App\Models\StudentProgress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $enrolledCourses = $student->courses()->with('instructor')->get();

        $pendingAssignments = $student->courses()
            ->whereHas('assignments', function ($q) use ($student) {
                $q->where('status', 'active')
                  ->where('due_date', '>', now())
                  ->whereDoesntHave('submissions', fn ($s) => $s->where('student_id', $student->id));
            })
            ->count();

        $avgGrade = $student->submissions()
            ->join('grades', 'grades.submission_id', '=', 'assignment_submissions.id')
            ->avg('grades.marks_obtained');

        $completedAssignments = $student->submissions()->whereHas('grade')->count();

        $recentNotifications = $student->notifications()->latest()->limit(5)->get();

        $upcomingSessions = LiveSession::with('course')
            ->whereIn('course_id', $student->courses()->pluck('courses.id'))
            ->whereIn('status', ['scheduled', 'live'])
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get();

        return view('student.dashboard', [
            'enrolledCourses' => $enrolledCourses,
            'pendingAssignments' => $pendingAssignments,
            'completedAssignments' => $completedAssignments,
            'averageGrade' => round($avgGrade ?? 0, 1),
            'recentNotifications' => $recentNotifications,
            'upcomingSessions' => $upcomingSessions,
        ]);
    }

    public function courses()
    {
        $student = auth()->user();

        $courses = Course::with('instructor', 'category')
            ->where('status', 'published')
            ->orderBy('title')
            ->get();

        $enrolledIds = $student->courses()->pluck('courses.id');

        return view('student.courses.index', compact('courses', 'enrolledIds'));
    }

    public function enroll(Course $course)
    {
        $student = auth()->user();

        if ($course->status !== 'published') {
            return back()->withErrors(['course' => 'This course is not open for enrollment.']);
        }

        $course->students()->syncWithoutDetaching([$student->id]);

        StudentProgress::firstOrCreate(
            ['student_id' => $student->id, 'course_id' => $course->id],
            ['completion_percentage' => 0]
        );

        Notification::notify(
            (string) $course->instructor_id,
            'enrollment',
            'New enrollment',
            "{$student->name} enrolled in \"{$course->title}\"."
        );

        ActivityLog::record('enrollment.created', "Student {$student->name} enrolled in {$course->title}", $course);

        return back()->with('success', "You have been enrolled in {$course->title}.");
    }

    public function unenroll(Course $course)
    {
        $student = auth()->user();

        if (! $student->courses()->where('courses.id', $course->id)->exists()) {
            return back()->withErrors(['course' => 'You are not enrolled in this course.']);
        }

        $course->students()->detach($student->id);

        StudentProgress::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->delete();

        ActivityLog::record('enrollment.deleted', "Student {$student->name} left {$course->title}", $course);

        return back()->with('success', "You have left {$course->title}.");
    }

    public function showCourse(Course $course)
    {
        $student = auth()->user();

        if (!$student->courses()->where('courses.id', $course->id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        $course->load([
            'lectureModules' => fn ($q) => $q->orderBy('sort_order')->orderBy('id')->with([
                'lectureMaterials' => fn ($q) => $q->orderBy('sort_order')->orderBy('created_at'),
            ]),
            'lectureMaterials' => fn ($q) => $q->orderBy('sort_order')->orderBy('created_at'),
            'assignments' => fn ($q) => $q->orderBy('due_date', 'asc'),
            'instructor',
        ]);

        $completedIds = LectureCompletion::where('student_id', $student->id)
            ->whereIn('lecture_material_id', $course->lectureMaterials->pluck('id'))
            ->pluck('lecture_material_id');

        $totalLessons = $course->lectureMaterials->count();
        $completedCount = $completedIds->count();
        $completionPercent = $totalLessons > 0 ? round($completedCount / $totalLessons * 100) : 0;

        return view('student.courses.show', [
            'course' => $course,
            'completedIds' => $completedIds,
            'completedCount' => $completedCount,
            'totalLessons' => $totalLessons,
            'completionPercent' => $completionPercent,
        ]);
    }

    public function completeLesson(LectureMaterial $material)
    {
        $student = auth()->user();

        if (!$student->courses()->where('courses.id', $material->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        LectureCompletion::firstOrCreate(
            ['student_id' => $student->id, 'lecture_material_id' => $material->id],
            ['completed_at' => now()]
        );

        $this->recalculateProgress($student, $material->course);

        ActivityLog::record('lesson.completed', "Student {$student->name} completed lesson {$material->title}", $material);

        return back()->with('success', "Lesson \"{$material->title}\" marked as complete.");
    }

    public function uncompleteLesson(LectureMaterial $material)
    {
        $student = auth()->user();

        if (!$student->courses()->where('courses.id', $material->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        LectureCompletion::where('student_id', $student->id)
            ->where('lecture_material_id', $material->id)
            ->delete();

        $this->recalculateProgress($student, $material->course);

        ActivityLog::record('lesson.uncompleted', "Student {$student->name} marked lesson {$material->title} as incomplete", $material);

        return back()->with('success', "Lesson \"{$material->title}\" marked as incomplete.");
    }

    private function recalculateProgress(User $student, Course $course): void
    {
        $materialIds = $course->lectureMaterials()->pluck('id');

        $completed = $materialIds->isNotEmpty()
            ? LectureCompletion::where('student_id', $student->id)
                ->whereIn('lecture_material_id', $materialIds)
                ->count()
            : 0;

        $total = $materialIds->count();
        $percentage = $total > 0 ? round($completed / $total * 100) : 0;

        StudentProgress::updateOrCreate(
            ['student_id' => $student->id, 'course_id' => $course->id],
            ['lectures_completed' => $completed, 'completion_percentage' => $percentage]
        );
    }

    public function downloadLecture(LectureMaterial $material)
    {
        $student = auth()->user();

        if (!$student->courses()->where('courses.id', $material->course_id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            abort(404, 'File not found.');
        }

        $extension = pathinfo($material->file_path, PATHINFO_EXTENSION);
        $name = \Illuminate\Support\Str::slug($material->title, '_') . '.' . $extension;

        return Storage::disk('public')->download($material->file_path, $name);
    }

    public function progress()
    {
        $progress = StudentProgress::where('student_id', auth()->id())
            ->with('course')
            ->get();

        return view('student.progress.index', ['progress' => $progress]);
    }
}
