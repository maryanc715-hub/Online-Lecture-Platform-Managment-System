@extends('layouts.app')

@section('title', $category->name)
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.course-categories.index') }}" class="hover:text-primary">Categories</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $category->name }}</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $category->name }}</h1>
            <p class="text-slate-500 text-sm">{{ $category->description ?? 'No description' }}</p>
        </div>
        <a href="{{ route('admin.course-categories.edit', $category) }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Edit Category</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="font-semibold text-primary">Courses in this Category ({{ $category->courses->count() }})</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Course</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Instructor</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($category->courses as $course)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $course->title }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $course->instructor->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = ['draft' => 'bg-slate-100 text-slate-500', 'published' => 'bg-green-100 text-green-700', 'archived' => 'bg-slate-200 text-slate-600'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$course->status] ?? '' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-400">{{ $course->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-empty-state title="No courses in this category yet" message="Courses added to this category will appear here." icon="book" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection