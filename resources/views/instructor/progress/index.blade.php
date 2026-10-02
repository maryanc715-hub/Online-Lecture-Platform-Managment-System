@extends('layouts.app')

@section('title', 'Student Progress')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Student Progress</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Student Progress</h1>
            <p class="text-slate-500 text-sm">Track student performance across your courses.</p>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex items-center gap-3 flex-1 rounded-btn border border-slate-200 bg-white px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                    <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                        @include('layouts.nav.icon', ['name' => 'search'])
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student name or email..."
                        class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
                </div>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Student</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Courses Enrolled</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Avg. Completion</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Progress Bar</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Avg. Grade</th>
                        <th class="text-right px-6 py-3 font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $student->avatar ? asset('storage/'.$student->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&background=40916C&color=fff' }}"
                                        class="w-8 h-8 rounded-full object-cover" alt="">
                                    <div>
                                        <p class="font-medium text-slate-700">{{ $student->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $student->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $student->progress->count() }}</td>
                            <td class="px-6 py-4 font-medium text-primary">{{ number_format($student->avg_completion, 1) }}%</td>
                            <td class="px-6 py-4">
                                <div class="w-24 bg-slate-100 rounded-full h-2">
                                    <div class="bg-secondary rounded-full h-2 transition-all"
                                        style="width: {{ $student->avg_completion }}%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $student->progress->avg('average_grade') ? number_format($student->progress->avg('average_grade'), 1) . '%' : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('instructor.progress.show', $student) }}" class="px-3 py-1.5 rounded-btn bg-secondary/10 text-secondary text-xs font-medium hover:bg-secondary/20 transition">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state title="No students found in your courses" message="Student progress will appear here once students enroll." icon="chart" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $students->links() }}
    </div>

@endsection
