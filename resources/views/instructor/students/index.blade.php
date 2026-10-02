@extends('layouts.app')

@section('title', 'Students')
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Students</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Students</h1>
            <p class="text-slate-500 text-sm">Manage student accounts and their status.</p>
        </div>
        <a href="{{ route('instructor.students.create') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">+ Add Student</a>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex items-center gap-3 flex-1 rounded-btn border border-slate-200 bg-white px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                    <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                        @include('layouts.nav.icon', ['name' => 'search'])
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email..."
                        class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
                </div>
                <select name="role" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : '' }}>{{ $role->label }}</option>
                    @endforeach
                </select>
                <select name="status" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Statuses</option>
                    @foreach(['active', 'pending', 'inactive', 'suspended'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">User</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Role</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Joined</th>
                        <th class="text-right px-6 py-3 font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=1B4332&color=fff' }}"
                                        class="w-9 h-9 rounded-full object-cover" alt="{{ $user->name }}">
                                    <div>
                                        <p class="font-medium text-slate-800">{{ $user->name }}</p>
                                        <p class="text-slate-400 text-xs">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/10 text-secondary capitalize">
                                    {{ $user->role->label ?? $user->role->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = ['active' => 'bg-green-100 text-green-700', 'pending' => 'bg-amber-100 text-amber-700', 'inactive' => 'bg-slate-100 text-slate-500', 'suspended' => 'bg-red-100 text-red-700'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$user->status] ?? 'bg-slate-100 text-slate-500' }}">
                                    {{ ucfirst($user->status ?? 'active') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-400">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($user->status === 'pending')
                                        <form action="{{ route('instructor.students.approve', $user) }}" method="POST">
                                            @csrf
                                            <button class="px-3 py-1.5 rounded-btn bg-green-50 text-green-700 text-xs font-medium hover:bg-green-100 transition">Approve</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('instructor.students.show', $user) }}" class="px-3 py-1.5 rounded-btn bg-secondary/10 text-secondary text-xs font-medium hover:bg-secondary/20 transition">View</a>
                                    <a href="{{ route('instructor.students.edit', $user) }}" class="px-3 py-1.5 rounded-btn bg-primary/5 text-primary text-xs font-medium hover:bg-primary/10 transition">Edit</a>
                                    <form action="{{ route('instructor.students.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete this student?')">
                                        @csrf @method('DELETE')
                                        <button class="px-3 py-1.5 rounded-btn bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-empty-state title="No students found" message="Students you add will appear here." icon="users" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection
