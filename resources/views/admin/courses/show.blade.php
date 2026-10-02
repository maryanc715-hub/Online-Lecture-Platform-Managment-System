@extends('layouts.app')

@section('title', $course->title)
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.courses.index') }}" class="hover:text-primary">Courses</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $course->title }}</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div class="flex items-start gap-4">
            @if($course->thumbnail_url)
                <img src="{{ $course->thumbnail_url }}" alt="" class="h-16 w-24 rounded-card object-cover border border-slate-200 flex-shrink-0">
            @endif
            <div>
            <h1 class="text-2xl font-bold text-primary">{{ $course->title }}</h1>
            <p class="text-slate-500 text-sm">{{ $course->category->name ?? 'Uncategorized' }} &middot; {{ $course->instructor->name ?? 'No instructor' }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.courses.edit', $course) }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Edit Course</a>
            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Delete this course?')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 rounded-btn bg-red-50 border border-red-200 text-red-600 text-sm font-medium hover:bg-red-100 transition">Delete</button>
            </form>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Course Details</h2>
            <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-slate-400 mb-1">Status</dt>
                    <dd>
                        @php
                            $statusColors = ['draft' => 'bg-slate-100 text-slate-500', 'published' => 'bg-green-100 text-green-700', 'archived' => 'bg-slate-200 text-slate-600'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$course->status] ?? '' }}">
                            {{ ucfirst($course->status) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Category</dt>
                    <dd class="font-medium text-slate-800">{{ $course->category->name ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Instructor</dt>
                    <dd class="font-medium text-slate-800">{{ $course->instructor->name ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Slug</dt>
                    <dd class="font-medium text-slate-800 text-xs">{{ $course->slug }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Start Date</dt>
                    <dd class="font-medium text-slate-800">{{ $course->start_date?->format('M d, Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">End Date</dt>
                    <dd class="font-medium text-slate-800">{{ $course->end_date?->format('M d, Y') ?? '—' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-slate-400 mb-1">Description</dt>
                    <dd class="font-medium text-slate-800">{{ $course->description ?? 'No description provided.' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Statistics</h2>
            <div class="space-y-4 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500">Lecture Materials</span>
                    <span class="font-semibold text-primary">{{ $course->lectureMaterials->count() }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Assignments</span>
                    <span class="font-semibold text-primary">{{ $course->assignments->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
            <h2 class="font-semibold text-primary">Enrolled Students ({{ $course->students_count }})</h2>
            <form action="{{ route('admin.courses.enroll', $course) }}" method="POST" class="flex gap-2">
                @csrf
                <select name="student_id" required
                    class="rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">Select a student...</option>
                    @foreach($availableStudents as $student)
                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ Enroll</button>
            </form>
        </div>

        @error('student_id')
            <p class="text-red-500 text-xs mb-3">{{ $message }}</p>
        @enderror

        @if($course->students->isEmpty())
            <p class="text-sm text-slate-500 py-4 text-center">No students enrolled yet. Select a student above to add them.</p>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach($course->students as $student)
                    <li class="py-3 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center text-xs font-bold">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">{{ $student->name }}</p>
                                <p class="text-xs text-slate-400">{{ $student->email }}</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.courses.unenroll', $course) }}" method="POST" onsubmit="return confirm('Remove this student from the course?')">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <button class="px-3 py-1.5 rounded-btn bg-red-50 border border-red-200 text-red-600 text-xs font-medium hover:bg-red-100 transition">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    @if($course->lectureMaterials->count())
        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
            <h2 class="font-semibold text-primary mb-4">Lecture Materials</h2>
            <ul class="divide-y divide-slate-100">
                @foreach($course->lectureMaterials as $material)
                    <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @include('layouts.nav.icon', ['name' => 'document'])
                            <span class="text-sm font-medium text-slate-700">{{ $material->title }}</span>
                        </div>
                        <span class="text-xs text-slate-400">{{ $material->created_at->format('M d, Y') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($course->assignments->count())
        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Assignments</h2>
            <ul class="divide-y divide-slate-100">
                @foreach($course->assignments as $assignment)
                    <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            @include('layouts.nav.icon', ['name' => 'clipboard'])
                            <span class="text-sm font-medium text-slate-700">{{ $assignment->title }}</span>
                        </div>
                        <span class="text-xs text-slate-400">{{ $assignment->due_date?->format('M d, Y') ?? 'No due date' }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection