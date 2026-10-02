@extends('layouts.app')

@section('title', $module->title)
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.modules.index') }}" class="hover:text-primary">Course Modules</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ Str::limit($module->title, 40) }}</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $module->title }}</h1>
            <p class="text-slate-500 text-sm">{{ $module->course->title ?? 'No course' }} &middot; Module {{ $module->sort_order }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('instructor.lectures.create', ['course_id' => $module->course_id, 'module_id' => $module->id]) }}"
                class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ Add Lesson</a>
            <a href="{{ route('instructor.modules.edit', $module) }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Edit</a>
        </div>
    </div>

    @if($module->description)
        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
            <h2 class="font-semibold text-primary mb-3">Description</h2>
            <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $module->description }}</div>
        </div>
    @endif

    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-primary">Lessons ({{ $module->lectureMaterials->count() }})</h2>
        </div>

        @if($module->lectureMaterials->isEmpty())
            <p class="text-sm text-slate-400 py-6 text-center">No lessons in this module yet. Click "+ Add Lesson" to upload one.</p>
        @else
            <ul class="divide-y divide-slate-100">
                @foreach($module->lectureMaterials as $material)
                    <li class="py-3 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-btn bg-secondary/10 flex items-center justify-center text-secondary flex-shrink-0">
                                <div class="w-4 h-4">
                                    @include('layouts.nav.icon', ['name' => $material->type === 'video' ? 'video' : 'document'])
                                </div>
                            </div>
                            <div class="min-w-0">
                                <a href="{{ route('instructor.lectures.show', $material) }}" class="text-sm font-medium text-slate-700 hover:text-primary">{{ $material->title }}</a>
                                <p class="text-xs text-slate-400 capitalize">{{ $material->type }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 flex-shrink-0">
                            <a href="{{ route('instructor.lectures.edit', $material) }}" class="text-secondary hover:text-primary text-xs font-medium">Edit</a>
                            <form action="{{ route('instructor.lectures.destroy', $material) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

@endsection
