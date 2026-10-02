@extends('layouts.app')

@section('title', 'Schedule Live Session')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.live-sessions.index') }}" class="hover:text-primary">Live Sessions</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Schedule Session</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Schedule Live Session</h1>
            <p class="text-slate-500 text-sm">Host a real-time video lecture via Jitsi Meet.</p>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 max-w-2xl">
        <form action="{{ route('instructor.live-sessions.store') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <div>
                    <label for="course_id" class="block text-sm font-medium text-slate-700 mb-1">Course</label>
                    <select name="course_id" id="course_id" required
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('course_id') border-red-500 @enderror">
                        <option value="">Select course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $selectedCourseId) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                        @endforeach
                    </select>
                    @error('course_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    @if($courses->isEmpty())
                        <p class="text-amber-600 text-xs mt-1">You need at least one course before scheduling a live session.</p>
                    @endif
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Session Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Week 5 - Live Q&A on Networking Protocols"
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('title') border-red-500 @enderror">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description <span class="text-slate-400 font-normal">(optional)</span></label>
                    <textarea name="description" id="description" rows="3" placeholder="What will this session cover?"
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="scheduled_at" class="block text-sm font-medium text-slate-700 mb-1">Start Date &amp; Time</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" value="{{ old('scheduled_at') }}" required
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('scheduled_at') border-red-500 @enderror">
                        @error('scheduled_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-slate-700 mb-1">Duration (minutes)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', 60) }}" min="5" max="480" required
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('duration_minutes') border-red-500 @enderror">
                        @error('duration_minutes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-100">
                <a href="{{ route('instructor.live-sessions.index') }}" class="px-4 py-2 rounded-btn border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Schedule Session</button>
            </div>
        </form>
    </div>

@endsection