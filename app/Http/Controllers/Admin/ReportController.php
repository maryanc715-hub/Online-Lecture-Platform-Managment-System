<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\LectureMaterial;
use App\Models\Report;
use App\Models\SupportTicket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with('generator')->latest()->get();

        return view('admin.reports.index', compact('reports'));
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'type'   => 'required|in:student,instructor,course,assignment,support,system',
            'title'  => 'required|string|max:255',
            'format' => 'required|in:pdf,excel',
        ]);

        [$headings, $rows] = $this->reportData($validated['type']);

        $extension = $validated['format'] === 'excel' ? 'xlsx' : 'pdf';
        $path = 'reports/' . Str::slug($validated['title']) . '-' . now()->format('Ymd-His') . '-' . Str::random(5) . '.' . $extension;

        if ($validated['format'] === 'excel') {
            Excel::store(new ReportExport($headings, $rows), $path, 'local');
        } else {
            $pdf = Pdf::loadView('admin.reports.pdf', [
                'title' => $validated['title'],
                'type' => $validated['type'],
                'headings' => $headings,
                'rows' => $rows,
            ])->setPaper('a4', 'landscape')->setOption('isFontSubsettingEnabled', true);

            Storage::disk('local')->put($path, $pdf->output());
        }

        $report = Report::create([
            'generated_by' => auth()->id(),
            'type'         => $validated['type'],
            'title'        => $validated['title'],
            'file_path'    => $path,
            'format'       => $validated['format'],
        ]);

        ActivityLog::record('report.generated', "Generated {$report->type} report: {$report->title}", $report);

        return back()->with('success', 'Report generated successfully.');
    }

    public function download(Report $report)
    {
        if (! $report->file_path) {
            abort(Response::HTTP_NOT_FOUND, 'Report file not available.');
        }

        $path = storage_path('app/' . $report->file_path);

        if (! file_exists($path)) {
            abort(Response::HTTP_NOT_FOUND, 'Report file not found on disk.');
        }

        $name = (Str::slug($report->title) ?: 'report') . '.' . pathinfo($path, PATHINFO_EXTENSION);

        return response()->download($path, $name);
    }

    /**
     * @return array{0: array<int, string>, 1: array<int, array<int, mixed>>}
     */
    private function reportData(string $type): array
    {
        return match ($type) {
            'student' => [
                ['Name', 'Email', 'Status', 'Courses Enrolled', 'Avg Completion (%)', 'Joined'],
                User::whereHas('role', fn ($q) => $q->where('name', 'student'))
                    ->withCount('courses')
                    ->withAvg('progress', 'completion_percentage')
                    ->orderBy('name')
                    ->get()
                    ->map(fn ($u) => [
                        $u->name,
                        $u->email,
                        ucfirst($u->status),
                        $u->courses_count,
                        round($u->progress_avg_completion_percentage ?? 0, 1),
                        $u->created_at?->format('Y-m-d'),
                    ])->all(),
            ],
            'instructor' => [
                ['Name', 'Email', 'Status', 'Courses', 'Lecture Materials', 'Joined'],
                User::whereHas('role', fn ($q) => $q->where('name', 'instructor'))
                    ->withCount('coursesTaught')
                    ->orderBy('name')
                    ->get()
                    ->map(fn ($u) => [
                        $u->name,
                        $u->email,
                        ucfirst($u->status),
                        $u->courses_taught_count,
                        LectureMaterial::where('instructor_id', $u->id)->count(),
                        $u->created_at?->format('Y-m-d'),
                    ])->all(),
            ],
            'course' => [
                ['Title', 'Category', 'Instructor', 'Status', 'Students', 'Lectures', 'Assignments'],
                Course::with(['category', 'instructor'])
                    ->withCount(['students', 'lectureMaterials', 'assignments'])
                    ->orderBy('title')
                    ->get()
                    ->map(fn ($c) => [
                        $c->title,
                        $c->category->name ?? '-',
                        $c->instructor->name ?? '-',
                        ucfirst($c->status),
                        $c->students_count,
                        $c->lecture_materials_count,
                        $c->assignments_count,
                    ])->all(),
            ],
            'assignment' => [
                ['Title', 'Course', 'Due Date', 'Status', 'Total Marks', 'Submissions', 'Graded'],
                Assignment::with('course')
                    ->withCount([
                        'submissions',
                        'submissions as graded_count' => fn ($q) => $q->where('status', 'graded'),
                    ])
                    ->orderBy('due_date')
                    ->get()
                    ->map(fn ($a) => [
                        $a->title,
                        $a->course->title ?? '-',
                        $a->due_date?->format('Y-m-d H:i'),
                        ucfirst($a->status),
                        $a->total_marks,
                        $a->submissions_count,
                        $a->graded_count,
                    ])->all(),
            ],
            'support' => [
                ['Ticket #', 'Subject', 'Student', 'Category', 'Priority', 'Status', 'Assigned To', 'Created'],
                SupportTicket::with(['student', 'category', 'assignee'])
                    ->latest()
                    ->get()
                    ->map(fn ($t) => [
                        $t->ticket_number,
                        $t->subject,
                        $t->student->name ?? '-',
                        $t->category->name ?? '-',
                        ucfirst($t->priority),
                        ucfirst(str_replace('_', ' ', $t->status)),
                        $t->assignee->name ?? 'Unassigned',
                        $t->created_at?->format('Y-m-d H:i'),
                    ])->all(),
            ],
            'system' => [
                ['Metric', 'Value'],
                [
                    ['Total users', User::count()],
                    ['Students', User::whereHas('role', fn ($q) => $q->where('name', 'student'))->count()],
                    ['Instructors', User::whereHas('role', fn ($q) => $q->where('name', 'instructor'))->count()],
                    ['Pending approvals', User::where('status', 'pending')->count()],
                    ['Courses', Course::count()],
                    ['Lecture materials', LectureMaterial::count()],
                    ['Assignments', Assignment::count()],
                    ['Support tickets', SupportTicket::count()],
                    ['Open support tickets', SupportTicket::whereIn('status', ['pending', 'in_progress'])->count()],
                    ['Activity log entries', ActivityLog::count()],
                ],
            ],
        };
    }
}
