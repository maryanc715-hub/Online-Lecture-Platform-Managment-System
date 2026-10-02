@extends('layouts.app')

@section('title', 'Edit Category')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.course-categories.index') }}" class="hover:text-primary">Categories</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Edit</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Edit Category</h1>
            <p class="text-slate-500 text-sm">Update <span class="font-medium text-slate-700">{{ $category->name }}</span>.</p>
        </div>
    </div>

    <form action="{{ route('admin.course-categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
            <div class="grid sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description <span class="text-slate-400">(optional)</span></label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.course-categories.index') }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">Save Changes</button>
        </div>
    </form>
@endsection