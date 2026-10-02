<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Course;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $announcements = Announcement::with(['creator', 'course'])
            ->when($request->audience, fn ($q) => $q->where('audience', $request->audience))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create', [
            'courses' => Course::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|in:all,students,instructors,support_staff',
            'course_id' => 'nullable|exists:courses,id',
            'is_published' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        $announcement = Announcement::create($validated);

        if ($validated['is_published']) {
            $this->notifyAudience($announcement);
        }

        ActivityLog::record('announcement.created', "Created announcement {$announcement->title}", $announcement);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created successfully.');
    }

    public function show(Announcement $announcement)
    {
        $announcement->load(['creator', 'course']);

        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', [
            'announcement' => $announcement,
            'courses' => Course::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|in:all,students,instructors,support_staff',
            'course_id' => 'nullable|exists:courses,id',
            'is_published' => 'boolean',
        ]);

        $isPublished = $request->boolean('is_published');
        $wasPublished = (bool) $announcement->is_published;
        $validated['is_published'] = $isPublished;

        if ($isPublished && ! $announcement->published_at) {
            $validated['published_at'] = now();
        } elseif (! $isPublished) {
            $validated['published_at'] = null;
        }

        $announcement->update($validated);

        if ($isPublished && ! $wasPublished) {
            $this->notifyAudience($announcement);
        }

        ActivityLog::record('announcement.updated', "Updated announcement {$announcement->title}", $announcement);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $title = $announcement->title;
        $announcement->delete();

        ActivityLog::record('announcement.deleted', "Deleted announcement {$title}");

        return back()->with('success', 'Announcement deleted successfully.');
    }

    private function notifyAudience(Announcement $announcement): void
    {
        $ids = collect();

        if ($announcement->course_id) {
            $course = Course::with('students')->find($announcement->course_id);
            $ids = collect($course?->students->pluck('id') ?? []);

            if ($course?->instructor_id && in_array($announcement->audience, ['all', 'instructors'], true)) {
                $ids->push($course->instructor_id);
            }
        } else {
            $ids = match ($announcement->audience) {
                'students' => User::whereHas('role', fn ($q) => $q->where('name', 'student'))->pluck('id'),
                'instructors' => User::whereHas('role', fn ($q) => $q->where('name', 'instructor'))->pluck('id'),
                'support_staff' => User::whereHas('role', fn ($q) => $q->where('name', 'support_staff'))->pluck('id'),
                default => User::pluck('id'),
            };
        }

        $ids->unique()->each(function ($id) use ($announcement) {
            Notification::notify(
                (string) $id,
                'announcement',
                'New announcement',
                $announcement->title
            );
        });
    }
}
