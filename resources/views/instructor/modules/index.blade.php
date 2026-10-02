@extends('layouts.app')

@section('title', 'Course Modules')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Course Modules</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Course Modules</h1>
            <p class="text-slate-500 text-sm">Organize your lecture materials into modules for each course.</p>
        </div>
        <a href="{{ route('instructor.modules.create', ['course_id' => request('course_id')]) }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ New Module</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex items-center gap-3 flex-1 rounded-btn border border-slate-200 bg-white px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                    <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                        @include('layouts.nav.icon', ['name' => 'search'])
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by module or course..."
                        class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
                </div>
                <select name="course_id" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Module</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Course</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Sort</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Lessons</th>
                        <th class="text-right px-6 py-3 font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($modules as $module)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-800">
                                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-btn bg-secondary/10 text-secondary text-xs font-bold mr-2">{{ $module->sort_order }}</span>
                                    <a href="{{ route('instructor.modules.show', $module) }}" class="text-primary hover:underline">{{ $module->title }}</a>
                                </p>
                                @if($module->description)
                                    <p class="text-slate-400 text-xs mt-0.5">{{ Str::limit($module->description, 80) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $module->course->title ?? 'No course' }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $module->sort_order }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $module->lectureMaterials->count() }} {{ Str::plural('lesson', $module->lectureMaterials->count()) }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('instructor.modules.edit', $module) }}" class="px-3 py-1.5 rounded-btn bg-secondary/10 text-secondary text-xs font-medium hover:bg-secondary/20 transition">Edit</a>
                                    <form action="{{ route('instructor.modules.destroy', $module) }}" method="POST" class="inline" onsubmit="return confirm('Delete this module? Its lessons will be kept but ungrouped.')">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-btn bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-empty-state title="No modules yet" message="Create modules to organize your lecture materials into course content." icon="menu" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $modules->links() }}
    </div>

@endsection
