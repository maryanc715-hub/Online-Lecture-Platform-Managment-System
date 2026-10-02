@extends('layouts.app')

@section('title', 'Live Sessions')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Live Sessions</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Live Sessions</h1>
            <p class="text-slate-500 text-sm">Schedule and host live Jitsi video sessions for your courses.</p>
        </div>
        <a href="{{ route('instructor.live-sessions.create') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ Schedule Session</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex items-center gap-3 flex-1 rounded-btn border border-slate-200 bg-white px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                    <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                        @include('layouts.nav.icon', ['name' => 'search'])
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by session title..."
                        class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
                </div>
                <select name="course_id" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Statuses</option>
                    @foreach(['scheduled' => 'Scheduled', 'live' => 'Live', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Session</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Course</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Schedule</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                        <th class="text-right px-6 py-3 font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-800">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-btn bg-secondary/10 text-secondary mr-2 [&_svg]:w-4 [&_svg]:h-4">
                                        @include('layouts.nav.icon', ['name' => 'video'])
                                    </span>
                                    <a href="{{ route('instructor.live-sessions.show', $session) }}" class="text-primary hover:underline">{{ $session->title }}</a>
                                </p>
                                @if($session->description)
                                    <p class="text-slate-400 text-xs mt-0.5">{{ Str::limit($session->description, 80) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $session->course->title ?? 'No course' }}</td>
                            <td class="px-6 py-4">
                                <p class="text-slate-700">{{ $session->scheduled_at->format('M j, Y') }}</p>
                                <p class="text-slate-400 text-xs">{{ $session->scheduled_at->format('g:i A') }} · {{ $session->duration_minutes }} min</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($session->isLive())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>Live
                                    </span>
                                @elseif($session->status === 'scheduled')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-medium">Scheduled</span>
                                @elseif($session->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-green-50 text-green-600 text-xs font-medium">Completed</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($session->status === 'live')
                                        <a href="{{ route('instructor.live-sessions.join', $session) }}" class="px-3 py-1.5 rounded-btn bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">Join</a>
                                    @elseif($session->isUpcoming())
                                        <a href="{{ route('instructor.live-sessions.edit', $session) }}" class="px-3 py-1.5 rounded-btn bg-secondary/10 text-secondary text-xs font-medium hover:bg-secondary/20 transition">Edit</a>
                                        <form action="{{ route('instructor.live-sessions.cancel', $session) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this session?')">
                                            @csrf
                                            <button class="px-3 py-1.5 rounded-btn bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">Cancel</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('instructor.live-sessions.show', $session) }}" class="px-3 py-1.5 rounded-btn bg-slate-100 text-slate-600 text-xs font-medium hover:bg-slate-200 transition">View</a>
                                    <form action="{{ route('instructor.live-sessions.destroy', $session) }}" method="POST" class="inline" onsubmit="return confirm('Delete this session?')">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-btn bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-empty-state title="No live sessions yet" message="Schedule a live session to host real-time video lectures with your students." icon="video" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $sessions->links() }}
    </div>

@endsection