@extends('layouts.app')

@section('title', $session->title)
@section('breadcrumbs')
    <a href="{{ route('instructor.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('instructor.live-sessions.index') }}" class="hover:text-primary">Live Sessions</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $session->title }}</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $session->title }}</h1>
            <p class="text-slate-500 text-sm">Manage and host this live session.</p>
        </div>
        <div class="flex items-center gap-2">
            @if($session->isLive())
                <a href="{{ route('instructor.live-sessions.join', $session) }}" class="px-4 py-2 rounded-btn bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>Join Session
                    </span>
                </a>
                <form action="{{ route('instructor.live-sessions.end', $session) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-btn border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50">End Session</button>
                </form>
            @elseif($session->isUpcoming())
                <a href="{{ route('instructor.live-sessions.join', $session) }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Start Session</a>
                <a href="{{ route('instructor.live-sessions.edit', $session) }}" class="px-4 py-2 rounded-btn border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50">Edit</a>
                <form action="{{ route('instructor.live-sessions.cancel', $session) }}" method="POST" onsubmit="return confirm('Cancel this session?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-btn border border-red-200 text-sm font-medium text-red-600 hover:bg-red-50">Cancel</button>
                </form>
            @endif
        </div>
    </div>

    @if($session->isLive())
        <div class="mb-6 rounded-card bg-red-600 text-white px-4 py-3 flex items-center gap-3 text-sm">
            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
            <span class="font-medium">This session is live right now. Students can join the video room.</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">Session Details</h2>

            @if($session->description)
                <p class="text-slate-600 leading-relaxed mb-6">{{ $session->description }}</p>
            @else
                <p class="text-slate-400 mb-6">No description provided for this session.</p>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-slate-50 rounded-btn p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase">Course</p>
                    <p class="mt-1 text-sm font-medium text-slate-700">{{ $session->course->title ?? 'N/A' }}</p>
                </div>
                <div class="bg-slate-50 rounded-btn p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase">Instructor</p>
                    <p class="mt-1 text-sm font-medium text-slate-700">{{ $session->instructor->name }}</p>
                </div>
                <div class="bg-slate-50 rounded-btn p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase">Scheduled</p>
                    <p class="mt-1 text-sm font-medium text-slate-700">{{ $session->scheduled_at->format('M j, Y g:i A') }}</p>
                </div>
                <div class="bg-slate-50 rounded-btn p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase">Duration</p>
                    <p class="mt-1 text-sm font-medium text-slate-700">{{ $session->duration_minutes }} minutes</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-primary mb-4">Status</h2>

            <div class="flex flex-col items-center py-4 text-center">
                @if($session->isLive())
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-50 text-red-600 text-sm font-semibold">
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>Live Now
                    </span>
                @elseif($session->status === 'scheduled')
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-50 text-amber-600 text-sm font-semibold">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>Scheduled
                    </span>
                @elseif($session->status === 'completed')
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-green-50 text-green-600 text-sm font-semibold">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>Completed
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 text-slate-500 text-sm font-semibold">
                        <span class="w-2 h-2 rounded-full bg-slate-400"></span>Cancelled
                    </span>
                @endif

                @if($session->scheduled_at->isFuture())
                    <p class="mt-4 text-sm text-slate-500">
                        Countdown to start:
                        <span class="font-semibold text-primary" id="countdown">...</span>
                    </p>
                @endif

                <div class="mt-4 pt-4 border-t border-slate-100 w-full text-left">
                    <p class="text-xs font-semibold text-slate-400 uppercase mb-2">Room</p>
                    <code class="text-xs bg-slate-100 px-2 py-1 rounded text-slate-600 break-all">{{ $session->jitsi_room_id }}</code>
                </div>

                @if($session->isUpcoming())
                    <form action="{{ route('instructor.live-sessions.start', $session) }}" method="POST" class="mt-4 w-full">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">
                            Start Session Now
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@if($session->scheduled_at->isFuture())
<script>
document.addEventListener('DOMContentLoaded', function () {
    var target = new Date('{{ $session->scheduled_at->format('Y-m-d\TH:i:sP') }}');
    var el = document.getElementById('countdown');
    if (!el) return;

    function pad(n) { return n < 10 ? '0' + n : n; }

    function tick() {
        var diff = target.getTime() - Date.now();
        if (diff <= 0) {
            el.textContent = 'Ready to start!';
            return true;
        }
        var d = Math.floor(diff / 86400000);
        var h = Math.floor((diff % 86400000) / 3600000);
        var m = Math.floor((diff % 3600000) / 60000);
        var s = Math.floor((diff % 60000) / 1000);
        el.textContent = (d > 0 ? d + 'd ' : '') + pad(h) + ':' + pad(m) + ':' + pad(s);
        return false;
    }

    tick();
    setInterval(tick, 1000);
});
</script>
@endif
@endpush