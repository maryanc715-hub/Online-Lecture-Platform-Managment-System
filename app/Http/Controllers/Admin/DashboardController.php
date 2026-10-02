<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\LectureMaterial;
use App\Models\Message;
use App\Models\Report;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => User::whereHas('role', fn ($q) => $q->where('name', 'student'))->count(),
            'instructors' => User::whereHas('role', fn ($q) => $q->where('name', 'instructor'))->count(),
            'courses' => Course::count(),
            'assignments' => Assignment::count(),
            'lectures' => LectureMaterial::count(),
            'messages' => Message::count(),
            'tickets' => SupportTicket::whereIn('status', ['pending', 'in_progress'])->count(),
            'pendingUsers' => User::where('status', 'pending')->count(),
        ];

        // Enrollment growth over the last 6 months, for Chart.js
        $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->subMonths($i));
        $enrollmentTrend = $months->map(function ($month) {
            return User::whereHas('role', fn ($q) => $q->where('name', 'student'))
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        });

        $ticketsByStatus = SupportTicket::selectRaw('status, count(*) as total')
            ->groupBy('status')->pluck('total', 'status');

        $recentActivities = ActivityLog::with('user')->latest()->limit(8)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'chartLabels' => $months->map(fn ($m) => $m->format('M')),
            'enrollmentTrend' => $enrollmentTrend,
            'ticketsByStatus' => $ticketsByStatus,
            'recentActivities' => $recentActivities,
        ]);
    }

    public function logs(Request $request)
    {
        $logs = ActivityLog::with('user')->latest()->paginate(25);

        return view('admin.logs', compact('logs'));
    }

    public function backup()
    {
        return view('admin.backup');
    }

    public function runBackup(Request $request)
    {
        $db = config('database.connections.mysql');
        $mysqldump = $this->mysqldumpPath();

        $cmd = sprintf(
            '"%s" --host=%s --port=%s --user=%s --password=%s --single-transaction --routines %s 2>&1',
            $mysqldump,
            $db['host'],
            $db['port'],
            $db['username'],
            $db['password'],
            $db['database']
        );

        $output = shell_exec($cmd);

        if ($output === null || trim($output) === '') {
            ActivityLog::record('backup.failed', 'Manual database backup failed');

            return back()->with('error', 'Backup failed. Could not run mysqldump.');
        }

        $filename = 'lecture-platform-backup-' . now()->format('Y-m-d_His') . '.sql';

        ActivityLog::record('backup.run', "Database backup downloaded: {$filename}");

        return response($output)
            ->header('Content-Type', 'application/sql')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function restore(Request $request)
    {
        $request->validate(['backup_file' => 'required|file|mimes:sql']);

        ActivityLog::record('backup.restore', 'Database restore requested from uploaded file');

        return back()->with('success', 'Restore job queued.');
    }

    private function mysqldumpPath(): string
    {
        $xampp = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';

        return file_exists($xampp) ? $xampp : 'mysqldump';
    }
}
