@extends('layouts.app')

@section('title', 'Edit Lecture Material')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.lectures.index') }}" class="hover:text-primary">Lecture Materials</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Edit</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Edit Lecture Material</h1>
            <p class="text-slate-500 text-sm">Update details for this material.</p>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 max-w-2xl">
        <form action="{{ route('instructor.lectures.update', $lecture) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $lecture->title) }}" required
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('title') border-red-500 @enderror">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">{{ old('description', $lecture->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="course_id" class="block text-sm font-medium text-slate-700 mb-1">Course</label>
                        <select name="course_id" id="course_id" required
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('course_id') border-red-500 @enderror">
                            <option value="">Select course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $lecture->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-slate-700 mb-1">Type</label>
                        <select name="type" id="type" required
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                            @foreach(['document', 'video', 'notes', 'other'] as $t)
                                <option value="{{ $t }}" {{ old('type', $lecture->type) === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label for="module_id" class="block text-sm font-medium text-slate-700 mb-1">Module <span class="text-slate-400 font-normal">(optional)</span></label>
                    <select name="module_id" id="module_id"
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('module_id') border-red-500 @enderror">
                        <option value="">No module (uncategorized)</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->id }}" data-course="{{ $module->course_id }}"
                                {{ old('module_id', $lecture->module_id) == $module->id ? 'selected' : '' }}>
                                {{ $module->course?->title ? $module->course->title . ' — ' : '' }}{{ $module->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('module_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-slate-400 mt-1">Only modules belonging to the selected course are available.</p>
                </div>

                <div id="notes-field" class="{{ $lecture->type === 'notes' ? '' : 'hidden' }}">
                    <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
                    <textarea name="notes" id="notes" rows="8"
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">{{ old('notes', $lecture->notes) }}</textarea>
                    @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="file" class="block text-sm font-medium text-slate-700 mb-1">Replace File <span class="text-slate-400 font-normal">(optional)</span></label>
                    @if($lecture->file_path)
                        <p class="text-xs text-slate-500 mb-2">Current: <a href="{{ asset('storage/'.$lecture->file_path) }}" target="_blank" class="text-secondary underline">{{ basename($lecture->file_path) }}</a></p>
                    @endif
                    <input type="file" name="file" id="file"
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary file:mr-3 file:py-1.5 file:px-3 file:rounded-btn file:border-0 file:text-sm file:font-medium file:bg-secondary/10 file:text-secondary hover:file:bg-secondary/20">
                    <p class="text-xs text-slate-400 mt-1">Max 100MB. Leave empty to keep current file.</p>
                    @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="video_url" class="block text-sm font-medium text-slate-700 mb-1">Video URL <span class="text-slate-400 font-normal">(optional)</span></label>
                    <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $lecture->video_url) }}" placeholder="https://youtube.com/watch?v=..."
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary @error('video_url') border-red-500 @enderror">
                    @error('video_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="category" class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                        <input type="text" name="category" id="category" value="{{ old('category', $lecture->category) }}" placeholder="e.g. Week 1"
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    </div>

                    <div>
                        <label for="visibility" class="block text-sm font-medium text-slate-700 mb-1">Visibility</label>
                        <select name="visibility" id="visibility" required
                            class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                            <option value="public" {{ old('visibility', $lecture->visibility) === 'public' ? 'selected' : '' }}>Public</option>
                            <option value="private" {{ old('visibility', $lecture->visibility) === 'private' ? 'selected' : '' }}>Private</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-100">
                <a href="{{ route('instructor.lectures.show', $lecture) }}" class="px-4 py-2 rounded-btn border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50">Cancel</a>
                <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Update Material</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script>
        function filterModules(courseId) {
            const select = document.getElementById('module_id');
            if (!select) return;
            select.querySelectorAll('option[data-course]').forEach(o => {
                o.hidden = courseId !== '' && o.dataset.course !== courseId;
                o.disabled = courseId !== '' && o.dataset.course !== courseId;
            });
            const selected = select.selectedOptions[0];
            if (selected && selected.hidden) {
                select.value = '';
            }
        }
        function toggleNotesField() {
            const typeSelect = document.getElementById('type');
            const notesField = document.getElementById('notes-field');
            if (typeSelect && notesField) {
                notesField.classList.toggle('hidden', typeSelect.value !== 'notes');
            }
        }
        const courseSelect = document.getElementById('course_id');
        if (courseSelect) {
            courseSelect.addEventListener('change', () => filterModules(courseSelect.value));
            filterModules(courseSelect.value);
        }
        const typeSelect = document.getElementById('type');
        if (typeSelect) {
            typeSelect.addEventListener('change', toggleNotesField);
            toggleNotesField();
        }
    </script>
@endpush
