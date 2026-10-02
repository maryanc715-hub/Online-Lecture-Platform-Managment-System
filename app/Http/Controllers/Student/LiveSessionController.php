<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    public function index(Request $request)
    {
        $student = auth()->user();

        $courseIds = $student->courses()->pluck('courses.id');

        $sessions = LiveSession::with(['course', 'instructor'])
            ->whereIn('course_id', $courseIds)
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->orderBy('scheduled_at')
            ->paginate(15)
            ->withQueryString();

        return view('student.live-sessions.index', compact('sessions'));
    }

    public function show(LiveSession $session)
    {
        $this->authorizeEnrollment($session);

        $session->load(['course', 'instructor', 'course.instructor']);

        return view('student.live-sessions.show', compact('session'));
    }

    public function join(LiveSession $session)
    {
        $this->authorizeEnrollment($session);

        if (! in_array($session->status, ['live', 'scheduled'])) {
            return redirect()->route('student.live-sessions.show', $session)
                ->with('error', 'This session is not available to join.');
        }

        if ($session->status === 'scheduled' && $session->scheduled_at->isFuture()) {
            return redirect()->route('student.live-sessions.show', $session)
                ->with('warning', 'This session has not started yet. Please check back at the scheduled time.');
        }

        $session->load(['course', 'instructor']);

        return view('student.live-sessions.join', compact('session'));
    }

    private function authorizeEnrollment(LiveSession $session): void
    {
        $enrolled = auth()->user()->courses()->where('course_id', $session->course_id)->exists();
        abort_unless($enrolled, 403, 'You must be enrolled in the course to join this session.');
    }
}