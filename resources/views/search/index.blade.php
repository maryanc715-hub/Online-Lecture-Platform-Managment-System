@extends('layouts.app')

@section('title', 'Search')
@section('breadcrumbs')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Search</span>
@endsection

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-primary">Search</h1>
        <p class="text-slate-500 text-sm">Find courses, students, assignments and lecture materials.</p>
    </div>

    <form action="{{ route('search') }}" method="GET" class="mb-6 flex gap-2">
        <div class="flex items-center gap-3 flex-1 rounded-btn border border-slate-200 bg-white px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
            <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                @include('layouts.nav.icon', ['name' => 'search'])
            </span>
            <input type="search" name="q" value="{{ $query }}" placeholder="Search courses, students, assignments..."
                class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
        </div>
        <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">Search</button>
    </form>

    @if($query === '')
        <div class="bg-white rounded-card shadow-sm border border-slate-100">
            <x-empty-state title="Start searching" message="Type a keyword above to search across the platform." icon="search" />
        </div>
    @elseif($courses->isEmpty() && $users->isEmpty() && $assignments->isEmpty() && $lectures->isEmpty())
        <div class="bg-white rounded-card shadow-sm border border-slate-100">
            <x-empty-state title="No results found" message="Nothing matched &quot;{{ $query }}&quot;. Try different keywords." icon="search" />
        </div>
    @else
        @if($courses->isNotEmpty())
            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-5 h-5 text-primary">
                        @include('layouts.nav.icon', ['name' => 'book'])
                    </div>
                    <h2 class="font-semibold text-primary">Courses</h2>
                    <span class="text-xs text-slate-400">({{ $courses->count() }})</span>
                </div>
                <ul class="divide-y divide-slate-100">
                    @foreach($courses as $course)
                        <li class="py-3 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-slate-700">{{ $course->title }}</p>
                                <p class="text-xs text-slate-400">{{ $course->category->name ?? 'Uncategorized' }} &middot; {{ $course->instructor->name ?? 'No instructor' }}</p>
                            </div>
                            @php $role = auth()->user()->role->name; @endphp
                            @if($role === 'admin')
                                <a href="{{ route('admin.courses.show', $course) }}" class="text-xs text-secondary hover:underline">View</a>
                            @elseif($role === 'instructor')
                                <a href="{{ route('instructor.courses.show', $course) }}" class="text-xs text-secondary hover:underline">View</a>
                            @elseif($role === 'student')
                                <a href="{{ route('student.courses.show', $course) }}" class="text-xs text-secondary hover:underline">View</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($users->isNotEmpty())
            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-5 h-5 text-primary">
                        @include('layouts.nav.icon', ['name' => 'users'])
                    </div>
                    <h2 class="font-semibold text-primary">Users</h2>
                    <span class="text-xs text-slate-400">({{ $users->count() }})</span>
                </div>
                <ul class="divide-y divide-slate-100">
                    @foreach($users as $user)
                        <li class="py-3 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-700">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $user->email }} &middot; <span class="capitalize">{{ str_replace('_', ' ', $user->role->name ?? '') }}</span></p>
                                </div>
                            </div>
                            <a href="{{ route('admin.users.show', $user) }}" class="text-xs text-secondary hover:underline">View</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($assignments->isNotEmpty())
            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-5 h-5 text-primary">
                        @include('layouts.nav.icon', ['name' => 'clipboard'])
                    </div>
                    <h2 class="font-semibold text-primary">Assignments</h2>
                    <span class="text-xs text-slate-400">({{ $assignments->count() }})</span>
                </div>
                <ul class="divide-y divide-slate-100">
                    @foreach($assignments as $assignment)
                        <li class="py-3 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-slate-700">{{ $assignment->title }}</p>
                                <p class="text-xs text-slate-400">{{ $assignment->course->title ?? 'No course' }} &middot; Due {{ $assignment->due_date?->format('M d, Y') ?? '—' }}</p>
                            </div>
                            @php $role = auth()->user()->role->name; @endphp
                            @if($role === 'admin')
                                <a href="{{ route('admin.courses.show', $assignment->course) }}" class="text-xs text-secondary hover:underline">View</a>
                            @elseif($role === 'instructor')
                                <a href="{{ route('instructor.assignments.show', $assignment) }}" class="text-xs text-secondary hover:underline">View</a>
                            @elseif($role === 'student')
                                <a href="{{ route('student.assignments.show', $assignment) }}" class="text-xs text-secondary hover:underline">View</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($lectures->isNotEmpty())
            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-5 h-5 text-primary">
                        @include('layouts.nav.icon', ['name' => 'document'])
                    </div>
                    <h2 class="font-semibold text-primary">Lecture Materials</h2>
                    <span class="text-xs text-slate-400">({{ $lectures->count() }})</span>
                </div>
                <ul class="divide-y divide-slate-100">
                    @foreach($lectures as $lecture)
                        <li class="py-3 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-medium text-slate-700">{{ $lecture->title }}</p>
                                <p class="text-xs text-slate-400">{{ $lecture->course->title ?? 'No course' }} &middot; <span class="capitalize">{{ $lecture->type }}</span></p>
                            </div>
                            @if(auth()->user()->hasRole('instructor'))
                                <a href="{{ route('instructor.lectures.show', $lecture) }}" class="text-xs text-secondary hover:underline">View</a>
                            @elseif(auth()->user()->hasRole('student') && $lecture->file_path)
                                <a href="{{ route('student.lectures.download', $lecture) }}" class="text-xs text-secondary hover:underline">Download</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
@endsection
