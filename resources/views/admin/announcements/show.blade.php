@extends('layouts.app')

@section('title', $announcement->title)
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.announcements.index') }}" class="hover:text-primary">Announcements</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $announcement->title }}</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $announcement->title }}</h1>
            <p class="text-slate-500 text-sm">By {{ $announcement->creator->name ?? 'Unknown' }} &middot; {{ $announcement->created_at->format('M d, Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Edit</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex items-center gap-4 mb-4 text-sm">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/10 text-secondary capitalize">
                {{ str_replace('_', ' ', $announcement->audience) }}
            </span>
            @if($announcement->course)
                <span class="text-slate-400">Course: <span class="text-slate-600 font-medium">{{ $announcement->course->title }}</span></span>
            @endif
            @if($announcement->is_published)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Published</span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">Draft</span>
            @endif
        </div>
        <div class="prose prose-sm max-w-none text-slate-700">
            {!! nl2br(e($announcement->body)) !!}
        </div>
    </div>

    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Delete this announcement?')">
        @csrf @method('DELETE')
        <button class="px-4 py-2 rounded-btn bg-red-50 border border-red-200 text-red-600 text-sm font-medium hover:bg-red-100 transition">Delete Announcement</button>
    </form>
@endsection