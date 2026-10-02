@extends('layouts.app')

@section('title', 'Edit Announcement')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.announcements.index') }}" class="hover:text-primary">Announcements</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Edit</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Edit Announcement</h1>
            <p class="text-slate-500 text-sm">Update <span class="font-medium text-slate-700">{{ $announcement->title }}</span>.</p>
        </div>
    </div>

    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" required
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="audience" class="block text-sm font-medium text-slate-700 mb-1">Audience</label>
                        <select name="audience" id="audience" required
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                            @foreach(['all', 'students', 'instructors', 'support_staff'] as $audience)
                                <option value="{{ $audience }}" {{ old('audience', $announcement->audience) === $audience ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $audience)) }}</option>
                            @endforeach
                        </select>
                        @error('audience')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-slate-700 mb-1">Related Course <span class="text-slate-400">(optional)</span></label>
                        <select name="course_id" id="course_id"
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                            <option value="">None</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $announcement->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="body" class="block text-sm font-medium text-slate-700 mb-1">Body</label>
                    <textarea name="body" id="body" rows="6" required
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">{{ old('body', $announcement->body) }}</textarea>
                    @error('body')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $announcement->is_published) ? 'checked' : '' }}
                        class="rounded border-slate-300 text-secondary focus:ring-secondary">
                    <label for="is_published" class="text-sm font-medium text-slate-700">Published</label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">Save Changes</button>
        </div>
    </form>
@endsection