<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Course;
use App\Models\LiveSession;
use App\Models\Notification;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    public function index(Request $request)
    {
        $courseIds = Course::where('instructor_id', auth()->id())->pluck('id');

        $sessions = LiveSession::with(['course', 'instructor'])
            ->whereIn('course_id', $courseIds)
            ->when($request->course_id, fn ($q) => $q->where('course_id', $request->course_id))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhereHas('course', fn ($c) => $c->where('title', 'like', "%{$request->search}%"));
            }))
            ->orderByDesc('scheduled_at')
            ->paginate(15)
            ->withQueryString();

        $courses = Course::where('instructor_id', auth()->id())->orderBy('title')->get();

        return view('instructor.live-sessions.index', compact('sessions', 'courses'));
    }

    public function create(Request $request)
    {
        $courses = Course::where('instructor_id', auth()->id())->orderBy('title')->get();

        return view('instructor.live-sessions.create', [
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
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:5|max:480',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $this->authorizeCourse($course);

        $session = LiveSession::create([
            'course_id' => $validated['course_id'],
            'instructor_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'scheduled_at' => $validated['scheduled_at'],
            'duration_minutes' => $validated['duration_minutes'],
        ]);

        $this->notifyEnrolledStudents($session);

        ActivityLog::record('live_session.created', "Created live session {$session->title}", $session);

        return redirect()->route('instructor.live-sessions.index')
            ->with('success', 'Live session scheduled successfully.');
    }

    public function show(LiveSession $session)
    {
        $this->authorizeSession($session);

        $session->load(['course', 'instructor']);

        return view('instructor.live-sessions.show', compact('session'));
    }

    public function edit(LiveSession $session)
    {
        $this->authorizeSession($session);
        abort_unless($session->status === 'scheduled', 403, 'Only scheduled sessions can be edited.');

        $courses = Course::where('instructor_id', auth()->id())->orderBy('title')->get();

        return view('instructor.live-sessions.edit', compact('session', 'courses'));
    }

    public function update(Request $request, LiveSession $session)
    {
        $this->authorizeSession($session);
        abort_unless($session->status === 'scheduled', 403, 'Only scheduled sessions can be updated.');

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:5|max:480',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $this->authorizeCourse($course);

        $session->update($validated);

        ActivityLog::record('live_session.updated', "Updated live session {$session->title}", $session);

        return redirect()->route('instructor.live-sessions.show', $session)
            ->with('success', 'Live session updated successfully.');
    }

    public function start(LiveSession $session)
    {
        $this->authorizeSession($session);

        if ($session->status === 'cancelled') {
            return back()->with('error', 'A cancelled session cannot be started.');
        }

        $session->update([
            'status' => 'live',
            'started_at' => now(),
        ]);

        ActivityLog::record('live_session.started', "Started live session {$session->title}", $session);

        return redirect()->route('instructor.live-sessions.join', $session)
            ->with('success', 'Live session started. Students can now join.');
    }

    public function join(LiveSession $session)
    {
        $this->authorizeSession($session);

        if (! in_array($session->status, ['live', 'scheduled'])) {
            return redirect()->route('instructor.live-sessions.show', $session)
                ->with('error', 'This session is not available to join.');
        }

        $session->load(['course', 'instructor']);

        return view('instructor.live-sessions.join', compact('session'));
    }

    public function end(LiveSession $session)
    {
        $this->authorizeSession($session);

        $session->update([
            'status' => 'completed',
            'ended_at' => now(),
        ]);

        ActivityLog::record('live_session.ended', "Ended live session {$session->title}", $session);

        return redirect()->route('instructor.live-sessions.index')
            ->with('success', 'Live session ended.');
    }

    public function cancel(LiveSession $session)
    {
        $this->authorizeSession($session);

        if (! in_array($session->status, ['scheduled'])) {
            return back()->with('error', 'Only scheduled sessions can be cancelled.');
        }

        $session->update(['status' => 'cancelled']);

        ActivityLog::record('live_session.cancelled', "Cancelled live session {$session->title}", $session);

        return redirect()->route('instructor.live-sessions.index')
            ->with('success', 'Live session cancelled.');
    }

    public function destroy(LiveSession $session)
    {
        $this->authorizeSession($session);

        $title = $session->title;
        $session->delete();

        ActivityLog::record('live_session.deleted', "Deleted live session {$title}");

        return redirect()->route('instructor.live-sessions.index')
            ->with('success', 'Live session deleted successfully.');
    }

    private function authorizeCourse(Course $course): void
    {
        abort_unless($course->instructor_id === auth()->id(), 403);
    }

    private function authorizeSession(LiveSession $session): void
    {
        abort_unless($session->instructor_id === auth()->id(), 403);
    }

    private function notifyEnrolledStudents(LiveSession $session): void
    {
        $students = $session->course->students;

        foreach ($students as $student) {
            Notification::notify(
                $student->id,
                'live_session',
                'New Live Session Scheduled',
                "A new live session \"{$session->title}\" has been scheduled for {$session->scheduled_at->format('M j, Y g:i A')} in {$session->course->title}."
            );
        }
    }
}