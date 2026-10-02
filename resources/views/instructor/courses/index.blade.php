@extends('layouts.app')

@section('title', 'My Courses')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">My Courses</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">My Courses</h1>
            <p class="text-slate-500 text-sm">All courses assigned to you.</p>
        </div>
        <a href="{{ route('instructor.lectures.create') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ Upload Material</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex items-center gap-3 flex-1 rounded-btn border border-slate-200 bg-white px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                    <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                        @include('layouts.nav.icon', ['name' => 'search'])
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search your courses..."
                        class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
                </div>
                <select name="category_id" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Course</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Category</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Students</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                        <th class="text-right px-6 py-3 font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($courses as $course)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($course->thumbnail_url)
                                        <img src="{{ $course->thumbnail_url }}" alt="" class="h-10 w-14 rounded object-cover border border-slate-200 flex-shrink-0">
                                    @else
                                        <div class="h-10 w-14 rounded bg-gradient-to-br from-secondary/90 to-primary/90 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ strtoupper(substr($course->title, 0, 2)) }}</div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $course->title }}</p>
                                        <p class="text-slate-400 text-xs">{{ $course->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $course->category->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $course->students_count ?? 0 }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = ['draft' => 'bg-slate-100 text-slate-500', 'published' => 'bg-green-100 text-green-700', 'archived' => 'bg-slate-200 text-slate-600'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$course->status] ?? 'bg-slate-100 text-slate-500' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('instructor.courses.show', $course) }}" class="px-3 py-1.5 rounded-btn bg-secondary/10 text-secondary text-xs font-medium hover:bg-secondary/20 transition">View</a>
                                    <a href="{{ route('instructor.courses.edit', $course) }}" class="px-3 py-1.5 rounded-btn bg-primary/5 text-primary text-xs font-medium hover:bg-primary/10 transition">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-empty-state title="No courses assigned to you yet" message="Courses assigned to you will appear here." icon="book" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $courses->links() }}
    </div>
@endsection
