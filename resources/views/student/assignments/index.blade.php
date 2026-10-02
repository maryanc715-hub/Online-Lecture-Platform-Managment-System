@extends('layouts.app')

@section('title', 'My Assignments')
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Assignments</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">My Assignments</h1>
            <p class="text-slate-500 text-sm">View and submit assignments from your enrolled courses.</p>
        </div>
    </div>

    @if($assignments->isEmpty())
        <div class="bg-white rounded-card shadow-sm border border-slate-100">
            <x-empty-state title="No assignments" message="There are no assignments for your enrolled courses yet." icon="clipboard" />
        </div>
    @else
        <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Assignment</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Course</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Due Date</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Marks</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-600">Status</th>
                        <th class="text-right px-5 py-3 font-semibold text-slate-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($assignments as $assignment)
                            @php
                                $submission = $assignment->submissions->first();
                                $submitted = $submission !== null;
                                $graded = $submitted && $submission->status === 'graded';
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 font-medium text-slate-700">{{ $assignment->title }}</td>
                                <td class="px-5 py-4 text-slate-500">{{ $assignment->course->title ?? 'N/A' }}</td>
                                <td class="px-5 py-4 text-slate-500">
                                    <span class="{{ $assignment->isOverdue() ? 'text-red-600 font-medium' : '' }}">
                                        {{ $assignment->due_date->format('M d, Y') }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-slate-500">{{ $assignment->total_marks }}</td>
                                <td class="px-5 py-4">
                                    @if($graded)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-green-100 text-green-700">Graded</span>
                                    @elseif($submitted)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-blue-100 text-blue-700">Submitted</span>
                                    @elseif($assignment->isOverdue())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-red-100 text-red-700">Overdue</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('student.assignments.show', $assignment) }}" class="text-secondary hover:text-primary text-xs font-medium">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection
