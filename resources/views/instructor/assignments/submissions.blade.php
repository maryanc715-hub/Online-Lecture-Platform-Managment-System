@extends('layouts.app')

@section('title', 'Submissions - ' . $assignment->title)
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.assignments.index') }}" class="hover:text-primary">Assignments</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.assignments.show', $assignment) }}" class="hover:text-primary">{{ Str::limit($assignment->title, 30) }}</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Submissions</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Submissions</h1>
            <p class="text-slate-500 text-sm">{{ $assignment->title }} &middot; {{ $assignment->submissions->count() }} submission(s)</p>
        </div>
        <a href="{{ route('instructor.assignments.show', $assignment) }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Back to Assignment</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Student</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Submitted At</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">File</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Note</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Grade</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($assignment->submissions as $submission)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $submission->student->avatar ? asset('storage/'.$submission->student->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($submission->student->name).'&background=40916C&color=fff' }}"
                                        class="w-8 h-8 rounded-full object-cover" alt="">
                                    <div>
                                        <p class="font-medium text-slate-700">{{ $submission->student->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $submission->student->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $submission->submitted_at->format('M d, Y g:i A') }}</td>
                            <td class="px-6 py-4">
                                @if($submission->file_path)
                                    <a href="{{ route('instructor.submissions.download', $submission) }}" class="text-secondary hover:text-primary text-xs font-medium underline">Download</a>
                                @else
                                    <span class="text-slate-400 text-xs">None</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-xs max-w-[200px] truncate">{{ $submission->submission_note ?: '-' }}</td>
                            <td class="px-6 py-4">
                                @if($submission->grade)
                                    <span class="font-semibold text-primary">{{ $submission->grade->marks_obtained }} / {{ $assignment->total_marks }}</span>
                                @else
                                    <span class="text-slate-400 text-xs">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="document.getElementById('grade-form-{{ $submission->id }}').classList.toggle('hidden')"
                                    class="text-secondary hover:text-primary text-xs font-medium">
                                    {{ $submission->grade ? 'Re-grade' : 'Grade' }}
                                </button>
                                <div id="grade-form-{{ $submission->id }}" class="hidden mt-3 bg-slate-50 rounded-btn p-4">
                                    <form action="{{ route('instructor.submissions.grade', $submission) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div>
                                            <label class="block text-xs font-medium text-slate-600 mb-1">Marks (out of {{ $assignment->total_marks }})</label>
                                            <input type="number" name="marks_obtained" min="0" max="{{ $assignment->total_marks }}" step="0.5"
                                                value="{{ $submission->grade?->marks_obtained ?? '' }}" required
                                                class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-slate-600 mb-1">Feedback</label>
                                            <textarea name="feedback" rows="2"
                                                class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary">{{ $submission->grade?->feedback ?? '' }}</textarea>
                                        </div>
                                        <button type="submit" class="px-4 py-1.5 rounded-btn bg-primary text-white text-xs font-medium hover:bg-primary-700">Submit Grade</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state title="No submissions received yet" message="Student submissions for this assignment will appear here." icon="clipboard" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
