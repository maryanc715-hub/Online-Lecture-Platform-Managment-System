@extends('layouts.app')

@section('title', $user->name)
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.users.index') }}" class="hover:text-primary">Users</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $user->name }}</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $user->name }}</h1>
            <p class="text-slate-500 text-sm">{{ $user->email }}</p>
        </div>
        <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Edit User</a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Profile Details</h2>
            <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-slate-400 mb-1">Name</dt>
                    <dd class="font-medium text-slate-800">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Email</dt>
                    <dd class="font-medium text-slate-800">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Phone</dt>
                    <dd class="font-medium text-slate-800">{{ $user->phone ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Role</dt>
                    <dd>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/10 text-secondary capitalize">
                            {{ $user->role->label ?? $user->role->name }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Status</dt>
                    <dd>
                        @php
                            $statusColors = ['active' => 'bg-green-100 text-green-700', 'inactive' => 'bg-slate-100 text-slate-500', 'suspended' => 'bg-red-100 text-red-700'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$user->status] ?? 'bg-slate-100 text-slate-500' }}">
                            {{ ucfirst($user->status ?? 'active') }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Joined</dt>
                    <dd class="font-medium text-slate-800">{{ $user->created_at->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Email Verified</dt>
                    <dd class="font-medium text-slate-800">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'Not verified' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Avatar</h2>
            <div class="flex justify-center">
                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=1B4332&color=fff&size=128' }}"
                    class="w-24 h-24 rounded-full object-cover" alt="{{ $user->name }}">
            </div>
        </div>
    </div>
@endsection