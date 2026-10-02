@extends('layouts.app')

@section('title', 'Create Assignment')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.assignments.index') }}" class="hover:text-primary">Assignments</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Create</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Create Assignment</h1>
            <p class="text-slate-500 text-sm">Create a new assignment for your students.</p>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 max-w-2xl">
        <form action="{{ route('instructor.assignments.store') }}" method="POST">
            @csrf

            <div class="space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('title') border-red-500 @enderror">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="5" required
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-slate-700 mb-1">Course</label>
                        <select name="course_id" id="course_id" required
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('course_id') border-red-500 @enderror">
                            <option value="">Select course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="total_marks" class="block text-sm font-medium text-slate-700 mb-1">Total Marks</label>
                        <input type="number" name="total_marks" id="total_marks" value="{{ old('total_marks', 100) }}" min="1" required
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('total_marks') border-red-500 @enderror">
                        @error('total_marks') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-slate-700 mb-1">Order <span class="text-slate-400 font-normal">(optional)</span></label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order') }}" min="0"
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('sort_order') border-red-500 @enderror">
                        @error('sort_order') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-slate-700 mb-1">Due Date</label>
                    <input type="datetime-local" name="due_date" id="due_date" value="{{ old('due_date') }}" required
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('due_date') border-red-500 @enderror">
                    @error('due_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-100">
                <a href="{{ route('instructor.assignments.index') }}" class="px-4 py-2 rounded-btn border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Create Assignment</button>
            </div>
        </form>
    </div>

@endsection
