@extends('layouts.app')

@section('title', 'My Profile')
@section('breadcrumbs')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Profile</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">My Profile</h1>
            <p class="text-slate-500 text-sm">Manage your personal information and account security.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Avatar</h2>
            <div class="flex flex-col items-center mb-4">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=1B4332&color=fff' }}"
                    class="w-24 h-24 rounded-full object-cover mb-3" alt="{{ $user->name }}">
                <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                <p class="text-xs text-slate-400 capitalize">{{ str_replace('_', ' ', $user->role->name ?? '') }}</p>
            </div>

            <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="avatar" class="block text-sm font-medium text-slate-700 mb-1">Upload Photo</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" required
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary file:mr-3 file:py-1.5 file:px-3 file:rounded-btn file:border-0 file:text-sm file:font-medium file:bg-secondary/10 file:text-secondary hover:file:bg-secondary/20">
                    @error('avatar')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">Update Photo</button>
            </form>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <form action="{{ route('profile.update') }}" method="POST" class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                @csrf
                @method('PUT')
                <h2 class="font-semibold text-primary mb-4">Account Information</h2>
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Phone <span class="text-slate-400">(optional)</span></label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-slate-700 mb-1">Student ID <span class="text-slate-400">(optional)</span></label>
                        <input type="text" name="student_id" id="student_id" value="{{ old('student_id', $user->student_id) }}"
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        @error('student_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">Save Changes</button>
                </div>
            </form>

            <form action="{{ route('profile.password') }}" method="POST" class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
                @csrf
                @method('PUT')
                <h2 class="font-semibold text-primary mb-4">Change Password</h2>
                <div class="grid sm:grid-cols-3 gap-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Current Password</label>
                        <input type="password" name="current_password" id="current_password" required
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    </div>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">Update Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
