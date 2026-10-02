@extends('layouts.app')

@section('title', 'Create Support Ticket')
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('student.support-tickets.index') }}" class="hover:text-primary">Support Center</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">New Ticket</span>
@endsection

@section('content')

    <div class="max-w-2xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
            <div>
                <h1 class="text-2xl font-bold text-primary">Create Support Ticket</h1>
                <p class="text-slate-500 text-sm">Describe your issue and we'll get back to you.</p>
            </div>
        </div>

        <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <form action="{{ route('student.support-tickets.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1">Category <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="w-full rounded-btn border border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-slate-700 mb-1">Subject <span class="text-red-500">*</span></label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                        class="w-full rounded-btn border border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary"
                        placeholder="Brief summary of your issue">
                    @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="5" required
                        class="w-full rounded-btn border border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary"
                        placeholder="Provide details about your issue...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-slate-700 mb-1">Priority <span class="text-red-500">*</span></label>
                    <select name="priority" id="priority" required
                        class="w-full rounded-btn border border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">
                        Submit Ticket
                    </button>
                    <a href="{{ route('student.support-tickets.index') }}" class="px-5 py-2.5 rounded-btn bg-white border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
