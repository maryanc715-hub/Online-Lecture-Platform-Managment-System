@extends('layouts.app')

@section('title', 'Notifications')
@section('breadcrumbs')
    <span class="font-medium text-primary">Notifications</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Notifications</h1>
            <p class="text-slate-500 text-sm">Stay up to date with platform activity.</p>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="divide-y divide-slate-100">
            @forelse($notifications as $notification)
                <div class="px-6 py-4 flex items-start gap-4 {{ is_null($notification->read_at) ? 'bg-secondary/5' : '' }}">
                    <div class="mt-1">
                        @if(is_null($notification->read_at))
                            <div class="w-2.5 h-2.5 rounded-full bg-secondary"></div>
                        @else
                            <div class="w-2.5 h-2.5 rounded-full bg-slate-200"></div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-slate-700">{{ is_array($notification->data) ? ($notification->data['message'] ?? json_encode($notification->data)) : ($notification->data ?? 'No data') }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</p>
                    </div>
                    @if(is_null($notification->read_at))
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            <button class="text-xs text-secondary hover:text-primary font-medium transition">Mark read</button>
                        </form>
                    @endif
                </div>
            @empty
                <div class="px-6 py-12 text-center text-slate-400 text-sm">
                    No notifications yet.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
@endsection