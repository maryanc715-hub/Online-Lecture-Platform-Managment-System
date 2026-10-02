@extends('layouts.app')

@section('title', 'Student Dashboard')
@section('breadcrumbs')
    <span class="font-medium text-primary">Dashboard</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h1>
            <p class="text-slate-500 text-sm">Here's an overview of your academic progress.</p>
        </div>
        <a href="{{ route('student.courses.index') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Browse Courses</a>
    </div>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'Enrolled Courses', 'value' => $enrolledCourses->count(), 'icon' => 'book'],
            ['label' => 'Pending Assignments', 'value' => $pendingAssignments, 'icon' => 'clipboard'],
            ['label' => 'Completed Assignments', 'value' => $completedAssignments, 'icon' => 'document'],
            ['label' => 'Average Grade', 'value' => $averageGrade . '%', 'icon' => 'award'],
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

    {{-- Live Sessions --}}
    @if($upcomingSessions->isNotEmpty())
    <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-primary">Live Sessions</h2>
            <a href="{{ route('student.live-sessions.index') }}" class="text-sm text-secondary hover:underline">View all</a>
        </div>
        <ul class="divide-y divide-slate-100">
            @foreach($upcomingSessions as $session)
                <li class="py-3">
                    <a href="{{ $session->isLive() ? route('student.live-sessions.join', $session) : route('student.live-sessions.show', $session) }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-btn bg-secondary/10 flex items-center justify-center text-secondary [&_svg]:w-5 [&_svg]:h-5">
                            @include('layouts.nav.icon', ['name' => 'video'])
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-700 group-hover:text-secondary truncate">
                                {{ $session->title }}
                                @if($session->isLive())
                                    <span class="inline-flex items-center gap-1 ml-2 px-2 py-0.5 rounded-full bg-red-50 text-red-600 text-xs font-medium">
                                        <span class="w-1 h-1 rounded-full bg-red-500 animate-pulse"></span>Live
                                    </span>
                                @endif
                            </p>
                            <p class="text-xs text-slate-400">{{ $session->course->title ?? '' }} · {{ $session->scheduled_at->format('M j, g:i A') }} · {{ $session->duration_minutes }} min</p>
                        </div>
                        <span class="flex items-center gap-1 text-secondary text-xs font-medium [&_svg]:w-5 [&_svg]:h-5">
                            {{ $session->isLive() ? 'Join' : 'Details' }}
                            @include('layouts.nav.icon', ['name' => 'chevron-right'])
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- My Courses --}}
        <div class="lg:col-span-2 bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-primary">My Courses</h2>
                <a href="{{ route('student.courses.index') }}" class="text-sm text-secondary hover:underline">View all</a>
            </div>
            <ul class="divide-y divide-slate-100">
                @forelse($enrolledCourses as $course)
                    <li class="py-3">
                        <a href="{{ route('student.courses.show', $course) }}" class="flex items-center gap-3 group">
                            @if($course->thumbnail_url)
                                <img src="{{ $course->thumbnail_url }}" alt="" class="w-10 h-10 rounded-btn object-cover flex-shrink-0">
                            @else
                                <div class="w-10 h-10 rounded-btn bg-secondary/10 flex items-center justify-center text-secondary text-sm font-bold">
                                    {{ strtoupper(substr($course->title, 0, 2)) }}
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-700 group-hover:text-secondary truncate">{{ $course->title }}</p>
                                <p class="text-xs text-slate-400">{{ $course->instructor->name ?? 'N/A' }}</p>
                            </div>
                            <span class="flex items-center gap-1 text-secondary text-xs font-medium [&_svg]:w-5 [&_svg]:h-5">
                                @include('layouts.nav.icon', ['name' => 'book'])
                                Continue
                            </span>
                        </a>
                    </li>
                @empty
                    <li class="py-6 text-center text-slate-400 text-sm">No courses enrolled yet.</li>
                @endforelse
            </ul>
        </div>

        {{-- Recent Notifications --}}
        <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-primary">Recent Notifications</h2>
                <a href="{{ route('notifications.index') }}" class="text-sm text-secondary hover:underline">View all</a>
            </div>
            <ul class="divide-y divide-slate-100">
                @forelse($recentNotifications as $notification)
                    <li class="py-3 flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-secondary mt-2 flex-shrink-0"></div>
                        <div class="text-sm min-w-0">
                            <p class="text-slate-700">{{ is_array($notification->data) ? ($notification->data['message'] ?? 'Notification') : ($notification->data ?? 'Notification') }}</p>
                            <p class="text-slate-400 text-xs">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </li>
                @empty
                    <li class="py-6 text-center text-slate-400 text-sm">No recent notifications.</li>
                @endforelse
            </ul>
        </div>
    </div>

@endsection