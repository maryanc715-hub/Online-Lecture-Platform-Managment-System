@extends('layouts.app')

@section('title', $assignment->title)
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.assignments.index') }}" class="hover:text-primary">Assignments</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ Str::limit($assignment->title, 40) }}</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $assignment->title }}</h1>
            <p class="text-slate-500 text-sm">{{ $assignment->course->title ?? 'No course' }} &middot; Due {{ $assignment->due_date->format('M d, Y \a\t g:i A') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('instructor.assignments.submissions', $assignment) }}" class="px-4 py-2 rounded-btn bg-secondary text-white text-sm font-medium hover:bg-secondary/90">View Submissions</a>
            <a href="{{ route('instructor.assignments.edit', $assignment) }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Edit</a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                <h2 class="font-semibold text-primary mb-3">Description</h2>
                <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $assignment->description }}</div>
            </div>

            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                <h2 class="font-semibold text-primary mb-4">Submissions ({{ $assignment->submissions->count() }})</h2>
                <div class="divide-y divide-slate-100">
                    @forelse($assignment->submissions as $submission)
                        <div class="py-3 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <img src="{{ $submission->student->avatar ? asset('storage/'.$submission->student->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($submission->student->name).'&background=40916C&color=fff' }}"
                                    class="w-8 h-8 rounded-full object-cover" alt="">
                                <div>
                                    <p class="text-sm font-medium text-slate-700">{{ $submission->student->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $submission->submitted_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($submission->grade)
                                    <span class="text-sm font-semibold text-primary">{{ $submission->grade->marks_obtained }} / {{ $assignment->total_marks }}</span>
                                @else
                                    <span class="text-xs text-slate-400">Not graded</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <x-empty-state title="No submissions yet" message="Student submissions will appear here once received." icon="clipboard" />
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                <h2 class="font-semibold text-primary mb-4">Details</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Course</dt>
                        <dd class="font-medium text-slate-700">{{ $assignment->course->title ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Total Marks</dt>
                        <dd class="font-medium text-slate-700">{{ $assignment->total_marks }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Due Date</dt>
                        <dd class="font-medium text-slate-700">{{ $assignment->due_date->format('M d, Y') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Status</dt>
                        <dd>
                            @if($assignment->status === 'active')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Closed</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Submissions</dt>
                        <dd class="font-medium text-slate-700">{{ $assignment->submissions->count() }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                <h2 class="font-semibold text-primary mb-4">Danger Zone</h2>
                <form action="{{ route('instructor.assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment?')">
                    @csrf @method('DELETE')
                    <button class="w-full px-4 py-2 rounded-btn border border-red-200 text-red-600 text-sm font-medium hover:bg-red-50">Delete Assignment</button>
                </form>
            </div>
        </div>
    </div>

@endsection
