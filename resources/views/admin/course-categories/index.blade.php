@extends('layouts.app')

@section('title', 'Course Categories')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Categories</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Course Categories</h1>
            <p class="text-slate-500 text-sm">Organize courses into categories.</p>
        </div>
        <a href="{{ route('admin.course-categories.create') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ Add Category</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Name</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Slug</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Courses</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Created</th>
                        <th class="text-right px-6 py-3 font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-800">{{ $category->name }}</p>
                                @if($category->description)
                                    <p class="text-slate-400 text-xs mt-0.5">{{ Str::limit($category->description, 60) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-400 text-xs">{{ $category->slug }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/10 text-secondary">
                                    {{ $category->courses_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-400">{{ $category->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.course-categories.show', $category) }}" class="px-3 py-1.5 rounded-btn bg-secondary/10 text-secondary text-xs font-medium hover:bg-secondary/20 transition">View</a>
                                    <a href="{{ route('admin.course-categories.edit', $category) }}" class="px-3 py-1.5 rounded-btn bg-primary/5 text-primary text-xs font-medium hover:bg-primary/10 transition">Edit</a>
                                    @if($category->courses_count === 0)
                                        <form action="{{ route('admin.course-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                                            @csrf @method('DELETE')
                                            <button class="px-3 py-1.5 rounded-btn bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-empty-state title="No categories found" message="Categories organize courses for easier discovery." icon="tag" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
@endsection