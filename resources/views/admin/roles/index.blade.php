@extends('layouts.app')

@section('title', 'Roles & Permissions')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Roles</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Roles & Permissions</h1>
            <p class="text-slate-500 text-sm">Manage role permissions for the platform.</p>
        </div>
    </div>

    <div class="space-y-4">
        @forelse($roles as $role)
            <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-primary">{{ $role->label }}</h2>
                        <p class="text-slate-500 text-sm">{{ $role->description ?? 'No description' }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-400">{{ $role->users_count }} users</span>
                        <a href="{{ route('admin.roles.edit', $role) }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Edit Permissions</a>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    @forelse($role->permissions as $permission)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/10 text-secondary">
                            {{ $permission->name }}
                        </span>
                    @empty
                        <span class="text-xs text-slate-400">No permissions assigned.</span>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="bg-white rounded-card shadow-sm border border-slate-100">
                <x-empty-state title="No roles found" message="Roles define the access levels on the platform." icon="shield" />
            </div>
        @endforelse
    </div>
@endsection