@extends('layouts.app')

@section('title', $student->name . ' - Progress')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.progress.index') }}" class="hover:text-primary">Student Progress</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $student->name }}</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div class="flex items-center gap-4">
            <img src="{{ $student->avatar ? asset('storage/'.$student->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=1B4332&color=fff&size=64' }}"
                class="w-14 h-14 rounded-full object-cover" alt="">
            <div>
                <h1 class="text-2xl font-bold text-primary">{{ $student->name }}</h1>
                <p class="text-slate-500 text-sm">{{ $student->email }}</p>
            </div>
        </div>
        <a href="{{ route('instructor.progress.index') }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Back to List</a>
    </div>

    @php
        $avgCompletion = $progress->avg('completion_percentage') ?? 0;
        $avgGrade = $progress->avg('average_grade') ?? 0;
    @endphp

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-card p-5 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm mb-1">Courses Enrolled</p>
            <p class="text-2xl font-bold text-primary">{{ $progress->count() }}</p>
        </div>
        <div class="bg-white rounded-card p-5 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm mb-1">Avg. Completion</p>
            <p class="text-2xl font-bold text-primary">{{ number_format($avgCompletion, 1) }}%</p>
        </div>
        <div class="bg-white rounded-card p-5 shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm mb-1">Avg. Grade</p>
            <p class="text-2xl font-bold text-primary">{{ number_format($avgGrade, 1) }}%</p>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-primary">Course Progress</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Course</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Completion</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Progress</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Lectures Done</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Assignments Done</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Avg. Grade</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($progress as $p)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $p->course->title ?? 'Unknown Course' }}</td>
                            <td class="px-6 py-4 font-medium text-primary">{{ number_format($p->completion_percentage, 1) }}%</td>
                            <td class="px-6 py-4">
                                <div class="w-32 bg-slate-100 rounded-full h-2">
                                    <div class="bg-secondary rounded-full h-2 transition-all"
                                        style="width: {{ $p->completion_percentage }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $p->lectures_completed ?? 0 }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $p->assignments_completed ?? 0 }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $p->average_grade ? number_format($p->average_grade, 1) . '%' : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state title="No progress data available" message="Progress will appear here as the student completes work." icon="chart" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
