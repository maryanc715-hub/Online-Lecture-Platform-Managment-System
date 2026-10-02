@extends('layouts.app')

@section('title', $lecture->title)
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.lectures.index') }}" class="hover:text-primary">Lecture Materials</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ Str::limit($lecture->title, 40) }}</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $lecture->title }}</h1>
            <p class="text-slate-500 text-sm">{{ $lecture->course->title ?? 'No course' }} &middot; {{ ucfirst($lecture->type) }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('instructor.lectures.edit', $lecture) }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Edit</a>
            <form action="{{ route('instructor.lectures.destroy', $lecture) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this material?')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 rounded-btn bg-red-50 border border-red-200 text-red-600 text-sm font-medium hover:bg-red-100">Delete</button>
            </form>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @if($lecture->description)
                <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                    <h2 class="font-semibold text-primary mb-3">Description</h2>
                    <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $lecture->description }}</div>
                </div>
            @endif

            @if($lecture->type === 'video' && $lecture->video_url)
                <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                    <h2 class="font-semibold text-primary mb-3">Video</h2>
                    <a href="{{ $lecture->video_url }}" target="_blank" class="text-secondary hover:text-primary text-sm font-medium underline">{{ $lecture->video_url }}</a>
                </div>
            @endif

            @if($lecture->file_path)
                <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                    <h2 class="font-semibold text-primary mb-3">Attached File</h2>
                    <a href="{{ asset('storage/'.$lecture->file_path) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-btn bg-secondary/10 text-secondary hover:bg-secondary/20 text-sm font-medium">
                        @include('layouts.nav.icon', ['name' => 'document'])
                        Download File
                    </a>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                <h2 class="font-semibold text-primary mb-4">Details</h2>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Course</dt>
                        <dd class="font-medium text-slate-700">{{ $lecture->course->title ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Type</dt>
                        <dd class="font-medium text-slate-700">{{ ucfirst($lecture->type) }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Module</dt>
                        <dd class="font-medium text-slate-700">{{ $lecture->module?->title ?: 'Uncategorized' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Category</dt>
                        <dd class="font-medium text-slate-700">{{ $lecture->category ?: '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Visibility</dt>
                        <dd>
                            @if($lecture->visibility === 'public')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Public</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Private</span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Created</dt>
                        <dd class="font-medium text-slate-700">{{ $lecture->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

@endsection
