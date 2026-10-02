@extends('layouts.app')

@section('title', 'Academic Progress')
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Academic Progress</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Academic Progress</h1>
            <p class="text-slate-500 text-sm">Track your completion and performance across enrolled courses.</p>
        </div>
    </div>

    @if($progress->isEmpty())
        <div class="bg-white rounded-card shadow-sm border border-slate-100">
            <x-empty-state title="No progress data" message="Your progress will appear once you start completing course materials." icon="chart" />
        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($progress as $record)
                <div class="bg-white rounded-card p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-btn bg-primary/10 flex items-center justify-center text-primary font-bold text-sm">
                            {{ strtoupper(substr($record->course->title ?? 'C', 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-sm font-semibold text-slate-700 truncate">{{ $record->course->title ?? 'Unknown Course' }}</h3>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mb-3">
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="text-slate-500">Completion</span>
                            <span class="font-semibold text-primary">{{ $record->completion_percentage }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5">
                            <div class="bg-secondary rounded-full h-2.5 transition-all duration-500" style="width: {{ $record->completion_percentage }}%"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 pt-3 border-t border-slate-100 text-center text-xs">
                        <div>
                            <p class="font-semibold text-slate-700">{{ $record->lectures_completed }}</p>
                            <p class="text-slate-400">Lectures</p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-700">{{ $record->assignments_completed }}</p>
                            <p class="text-slate-400">Assignments</p>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-700">{{ $record->average_grade ?? '-' }}%</p>
                            <p class="text-slate-400">Avg Grade</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
