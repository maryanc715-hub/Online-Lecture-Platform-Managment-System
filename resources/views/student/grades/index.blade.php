@extends('layouts.app')

@section('title', 'My Grades')
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Grades</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">My Grades</h1>
            <p class="text-slate-500 text-sm">View feedback and marks for your submitted assignments.</p>
        </div>
    </div>

    @if($gradedSubmissions->isEmpty())
        <div class="bg-white rounded-card shadow-sm border border-slate-100">
            <x-empty-state title="No grades yet" message="Your grades will appear here once your assignments are graded." icon="award" />
        </div>
    @else
        <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Assignment</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Course</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Submitted</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Marks</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Feedback</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($gradedSubmissions as $submission)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 font-medium text-slate-700">{{ $submission->assignment->title ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-slate-500">{{ $submission->assignment->course->title ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-slate-500">{{ $submission->submitted_at->format('M d, Y') }}</td>
                                <td class="px-5 py-4">
                                    <span class="font-bold text-primary">{{ $submission->grade->marks_obtained }}</span>
                                    <span class="text-slate-400"> / {{ $submission->assignment->total_marks }}</span>
                                </td>
                                <td class="px-5 py-4 text-slate-500 max-w-xs">
                                    <p class="truncate" title="{{ $submission->grade->feedback ?? '' }}">{{ $submission->grade->feedback ?? '-' }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection
