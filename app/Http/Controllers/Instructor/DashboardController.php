<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\LectureMaterial;
use App\Models\LiveSession;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $instructorId = auth()->id();

        $totalCourses = Course::where('instructor_id', $instructorId)->count();

        $totalStudents = User::whereHas('role', fn ($q) => $q->where('name', 'student'))->count();

        $totalAssignments = Assignment::where('instructor_id', $instructorId)->count();

        $totalMaterials = LectureMaterial::where('instructor_id', $instructorId)->count();

        $recentActivity = ActivityLog::with('user')
            ->where('user_id', $instructorId)
            ->latest()
            ->limit(10)
            ->get();

        $upcomingSessions = LiveSession::with('course')
            ->where('instructor_id', $instructorId)
            ->whereIn('status', ['scheduled', 'live'])
            ->orderBy('scheduled_at')
            ->limit(5)
            ->get();

        return view('instructor.dashboard', compact(
            'totalCourses',
            'totalStudents',
            'totalAssignments',
            'totalMaterials',
            'recentActivity',
            'upcomingSessions',
        ));
    }
}
