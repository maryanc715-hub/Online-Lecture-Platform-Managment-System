@extends('layouts.app')

@section('title', 'Edit Role')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.roles.index') }}" class="hover:text-primary">Roles</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $role->label }}</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Edit Role: {{ $role->label }}</h1>
            <p class="text-slate-500 text-sm">{{ $role->description ?? 'Manage permissions for this role.' }}</p>
        </div>
    </div>

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
            <div class="space-y-6">
                <div>
                    <label for="label" class="block text-sm font-medium text-slate-700 mb-1">Label</label>
                    <input type="text" name="label" id="label" value="{{ old('label', $role->label) }}" required
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    @error('label')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description <span class="text-slate-400">(optional)</span></label>
                    <input type="text" name="description" id="description" value="{{ old('description', $role->description) }}"
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
            <h2 class="font-semibold text-primary mb-4">Permissions</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($permissions as $permission)
                    <label class="flex items-center gap-3 p-3 rounded-btn border border-slate-100 hover:bg-slate-50/50 transition cursor-pointer">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                            class="rounded border-slate-300 text-secondary focus:ring-secondary">
                        <span class="text-sm text-slate-700">{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('permissions')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">Save Changes</button>
        </div>
    </form>
@endsection