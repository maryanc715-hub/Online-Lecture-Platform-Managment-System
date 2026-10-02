@extends('layouts.app')

@section('title', $assignment->title)
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('student.assignments.index') }}" class="hover:text-primary">Assignments</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $assignment->title }}</span>
@endsection

@section('content')

    <div class="max-w-3xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
            <div>
                <h1 class="text-2xl font-bold text-primary">{{ $assignment->title }}</h1>
                <p class="text-slate-500 text-sm">
                    {{ $assignment->course->title ?? 'N/A' }}
                    <span class="mx-1">&middot;</span>
                    Instructor: {{ $assignment->instructor->name ?? 'N/A' }}
                </p>
            </div>
        </div>

        {{-- Assignment Info --}}
        <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100 mb-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-4">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Due Date</p>
                    <p class="text-sm font-semibold {{ $assignment->isOverdue() ? 'text-red-600' : 'text-slate-700' }}">{{ $assignment->due_date->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Total Marks</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $assignment->total_marks }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Status</p>
                    @if($existingSubmission && $existingSubmission->status === 'graded')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-green-100 text-green-700">Graded</span>
                    @elseif($existingSubmission)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-blue-100 text-blue-700">Submitted</span>
                    @elseif($assignment->isOverdue())
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-red-100 text-red-700">Overdue</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                    @endif
                </div>
            </div>

            @if($assignment->description)
                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-700 mb-2">Description</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $assignment->description }}</p>
                </div>
            @endif

            @if($assignment->attachment)
                <div class="pt-4 mt-4 border-t border-slate-100">
                    <a href="{{ asset('storage/' . $assignment->attachment) }}" target="_blank" class="inline-flex items-center gap-2 text-secondary hover:text-primary text-sm font-medium">
                        <div class="w-4 h-4">
                            @include('layouts.nav.icon', ['name' => 'download'])
                        </div>
                        Download Attachment
                    </a>
                </div>
            @endif
        </div>

        {{-- Grade Result --}}
        @if($existingSubmission && $existingSubmission->status === 'graded' && $existingSubmission->grade)
            <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100 mb-6">
                <h3 class="font-semibold text-primary mb-3">Grade Result</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Marks Obtained</p>
                        <p class="text-2xl font-bold text-primary">{{ $existingSubmission->grade->marks_obtained }} <span class="text-sm font-normal text-slate-400">/ {{ $assignment->total_marks }}</span></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Graded On</p>
                        <p class="text-sm font-semibold text-slate-700">{{ $existingSubmission->grade->graded_at->format('M d, Y') }}</p>
                    </div>
                </div>
                @if($existingSubmission->grade->feedback)
                    <div class="mt-3 pt-3 border-t border-slate-100">
                        <p class="text-xs text-slate-400 mb-1">Feedback</p>
                        <p class="text-sm text-slate-600">{{ $existingSubmission->grade->feedback }}</p>
                    </div>
                @endif
            </div>
        @endif

        {{-- Submission Form --}}
        @if(!$existingSubmission && !$assignment->isOverdue())
            <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
                <h3 class="font-semibold text-primary mb-4">Submit Your Work</h3>
                <form action="{{ route('student.assignments.submit', $assignment) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="submission_file" class="block text-sm font-medium text-slate-700 mb-1">Upload File <span class="text-red-500">*</span></label>
                        <input type="file" name="submission_file" id="submission_file" required
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary file:mr-3 file:py-1.5 file:px-3 file:rounded-btn file:border-0 file:text-sm file:font-medium file:bg-secondary/10 file:text-secondary hover:file:bg-secondary/20">
                        <p class="text-xs text-slate-400 mt-1">Accepted: PDF, DOC, DOCX, ZIP, RAR (max 20MB)</p>
                        @error('submission_file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="submission_note" class="block text-sm font-medium text-slate-700 mb-1">Note (optional)</label>
                        <textarea name="submission_note" id="submission_note" rows="3"
                            class="w-full rounded-btn border border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary"
                            placeholder="Add any notes about your submission...">{{ old('submission_note') }}</textarea>
                        @error('submission_note')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="px-5 py-2.5 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">
                        Submit Assignment
                    </button>
                </form>
            </div>
        @elseif($existingSubmission)
            <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
                <h3 class="font-semibold text-primary mb-3">Your Submission</h3>
                <div class="space-y-2 text-sm">
                    <p class="text-slate-600"><span class="font-medium">Submitted:</span> {{ $existingSubmission->submitted_at->format('M d, Y h:i A') }}</p>
                    @if($existingSubmission->submission_note)
                        <p class="text-slate-600"><span class="font-medium">Note:</span> {{ $existingSubmission->submission_note }}</p>
                    @endif
                    @if($existingSubmission->file_path)
                        <a href="{{ route('student.assignments.submission.download', $assignment) }}" class="inline-flex items-center gap-1 text-secondary hover:text-primary font-medium">
                            <div class="w-4 h-4">
                                @include('layouts.nav.icon', ['name' => 'download'])
                            </div>
                            Download Submission
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

@endsection
