@extends('layouts.app')

@section('title', 'System Logs')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">System Logs</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">System Logs</h1>
            <p class="text-slate-500 text-sm">Audit trail of all actions across the platform.</p>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Event</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Description</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">User</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary/10 text-secondary">
                                    {{ $log->event }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-700">{{ $log->description }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $log->user->name ?? 'System' }}</td>
                            <td class="px-6 py-4 text-slate-400 text-xs">{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-empty-state title="No logs found" message="System activity will be logged here." icon="clock" />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>
@endsection