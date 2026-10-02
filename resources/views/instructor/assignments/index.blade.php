@extends('layouts.app')

@section('title', 'My Assignments')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Assignments</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">My Assignments</h1>
            <p class="text-slate-500 text-sm">Manage and review assignments for your courses.</p>
        </div>
        <a href="{{ route('instructor.assignments.create') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ New Assignment</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex items-center gap-3 flex-1 rounded-btn border border-slate-200 bg-white px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                    <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                        @include('layouts.nav.icon', ['name' => 'search'])
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or course..."
                        class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
                </div>
                <select name="status" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Title</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Course</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Due Date</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Submissions</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Order</th>
                        <th class="text-right px-6 py-3 font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($assignments as $assignment)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <a href="{{ route('instructor.assignments.show', $assignment) }}" class="font-medium text-primary hover:underline">{{ $assignment->title }}</a>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $assignment->course->title ?? '-' }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $assignment->due_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                @if($assignment->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Closed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $assignment->submissions_count ?? $assignment->submissions->count() }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">{{ $assignment->sort_order }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('instructor.assignments.submissions', $assignment) }}" class="px-3 py-1.5 rounded-btn bg-secondary/10 text-secondary text-xs font-medium hover:bg-secondary/20 transition">Submissions</a>
                                    <a href="{{ route('instructor.assignments.edit', $assignment) }}" class="px-3 py-1.5 rounded-btn bg-primary/5 text-primary text-xs font-medium hover:bg-primary/10 transition">Edit</a>
                                    <form action="{{ route('instructor.assignments.destroy', $assignment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-btn bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state title="No assignments found" message="Create assignments for your courses." icon="clipboard" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $assignments->links() }}
    </div>

@endsection
