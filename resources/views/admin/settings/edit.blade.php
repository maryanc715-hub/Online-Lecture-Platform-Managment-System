@extends('layouts.app')

@section('title', 'Settings')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Settings</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Platform Settings</h1>
            <p class="text-slate-500 text-sm">Manage platform-wide configuration values.</p>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="font-semibold text-primary">Key / Value Pairs</h2>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($settings as $index => $setting)
                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="flex-1">
                            <input type="text"
                                name="settings[{{ $index }}][key]"
                                value="{{ $setting->key }}"
                                required
                                class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-secondary focus:border-secondary"
                                placeholder="Setting key">
                        </div>
                        <div class="flex-1">
                            <input type="text"
                                name="settings[{{ $index }}][value]"
                                value="{{ $setting->value }}"
                                class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary"
                                placeholder="Value">
                        </div>
                        <div class="w-10"></div>
                    </div>
                @empty
                    <x-empty-state title="No settings yet" message="Add key/value pairs below to get started." icon="cog" />
                @endforelse
            </div>

            {{-- Add new row --}}
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                <p class="text-xs text-slate-400 mb-3">Add new setting</p>
                <div class="flex items-center gap-4" id="new-setting-row">
                    <div class="flex-1">
                        <input type="text"
                            name="settings[{{ $settings->count() }}][key]"
                            class="w-full rounded-btn border-slate-200 bg-white text-sm font-medium text-slate-700 focus:ring-2 focus:ring-secondary focus:border-secondary"
                            placeholder="New key">
                    </div>
                    <div class="flex-1">
                        <input type="text"
                            name="settings[{{ $settings->count() }}][value]"
                            class="w-full rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary"
                            placeholder="New value">
                    </div>
                    <div class="w-10"></div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">
                Save Settings
            </button>
        </div>
    </form>

    @error('settings')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
@endsection
