@extends('layouts.app')

@section('title', 'Instructor Dashboard')
@section('breadcrumbs')
    <span class="font-medium text-primary">Dashboard</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h1>
            <p class="text-slate-500 text-sm">Here's an overview of your courses and activity.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('instructor.assignments.create') }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">+ New Assignment</a>
            <a href="{{ route('instructor.lectures.create') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ Upload Material</a>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'My Courses', 'value' => $totalCourses, 'icon' => 'book'],
            ['label' => 'Total Students', 'value' => $totalStudents, 'icon' => 'users'],
            ['label' => 'Assignments', 'value' => $totalAssignments, 'icon' => 'clipboard'],
            ['label' => 'Lecture Materials', 'value' => $totalMaterials, 'icon' => 'document'],
        ] as $card)
        <div class="bg-white rounded-card p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-btn bg-secondary/10 flex items-center justify-center text-secondary">
                    @include('layouts.nav.icon', ['name' => $card['icon']])
                </div>
            </div>
            <p class="text-2xl font-bold text-primary">{{ $card['value'] }}</p>
            <p class="text-slate-500 text-sm">{{ $card['label'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-primary mb-4">Recent Activity</h2>
            <ul class="divide-y divide-slate-100">
                @forelse($recentActivity as $log)
                    <li class="py-3 flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-secondary mt-2"></div>
                        <div class="text-sm">
                            <p class="text-slate-700">{{ $log->description }}</p>
                            <p class="text-slate-400 text-xs">{{ $log->created_at->diffForHumans() }}</p>
                        </div>
                    </li>
                @empty
                    <li>
                        <x-empty-state title="No recent activity" message="Activity in your courses will appear here." icon="clock" />
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-primary">Upcoming Sessions</h2>
                <a href="{{ route('instructor.live-sessions.create') }}" class="text-xs font-medium text-secondary hover:underline">+ Schedule</a>
            </div>
            <ul class="space-y-3">
                @forelse($upcomingSessions as $session)
                    <li class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-btn bg-secondary/10 flex items-center justify-center text-secondary flex-shrink-0 [&_svg]:w-4 [&_svg]:h-4">
                            @include('layouts.nav.icon', ['name' => 'video'])
                        </div>
                        <div class="text-sm min-w-0">
                            @if($session->isLive())
                                <a href="{{ route('instructor.live-sessions.join', $session) }}" class="font-medium text-red-600 hover:underline inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>{{ $session->title }}
                                </a>
                            @else
                                <a href="{{ route('instructor.live-sessions.show', $session) }}" class="font-medium text-primary hover:underline block truncate">{{ $session->title }}</a>
                            @endif
                            <p class="text-slate-400 text-xs">{{ $session->course->title ?? '' }} · {{ $session->scheduled_at->format('M j, g:i A') }}</p>
                        </div>
                    </li>
                @empty
                    <li>
                        <x-empty-state title="No sessions scheduled" message="Schedule a live session for your students." icon="video" />
                    </li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <h2 class="font-semibold text-primary mb-4">Quick Actions</h2>
            <div class="space-y-2 text-sm">
                <a href="{{ route('instructor.live-sessions.create') }}" class="block px-4 py-2.5 rounded-btn bg-primary/5 hover:bg-primary/10 text-primary font-medium">Schedule Live Session</a>
                <a href="{{ route('instructor.courses.index') }}" class="block px-4 py-2.5 rounded-btn bg-primary/5 hover:bg-primary/10 text-primary font-medium">View My Courses</a>
                <a href="{{ route('instructor.assignments.create') }}" class="block px-4 py-2.5 rounded-btn bg-primary/5 hover:bg-primary/10 text-primary font-medium">Create Assignment</a>
                <a href="{{ route('instructor.lectures.create') }}" class="block px-4 py-2.5 rounded-btn bg-primary/5 hover:bg-primary/10 text-primary font-medium">Upload Lecture Material</a>
                <a href="{{ route('instructor.progress.index') }}" class="block px-4 py-2.5 rounded-btn bg-primary/5 hover:bg-primary/10 text-primary font-medium">View Student Progress</a>
            </div>
        </div>
    </div>

@endsection
