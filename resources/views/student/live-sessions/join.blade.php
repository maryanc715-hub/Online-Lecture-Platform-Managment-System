@extends('layouts.app')

@section('title', 'Join - ' . $session->title)
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('student.live-sessions.index') }}" class="hover:text-primary">Live Sessions</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $session->title }}</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $session->title }}</h1>
            <p class="text-slate-500 text-sm">{{ $session->course->title ?? '' }} · {{ $session->scheduled_at->format('M j, Y g:i A') }}</p>
        </div>
        @if($session->isLive())
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-50 text-red-600 text-sm font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>Live
            </span>
        @endif
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="aspect-video w-full" id="jitsi-container"></div>
    </div>

    <div class="mt-4 text-center">
        <p class="text-sm text-slate-500">
            Video room: <code class="text-xs bg-slate-100 px-2 py-0.5 rounded text-slate-600">{{ $session->jitsi_room_id }}</code>
        </p>
    </div>

@endsection

@push('scripts')
<script src="{{ rtrim(config('services.jitsi.server', 'https://meet.jit.si'), '/') }}/external_api.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var domain = '{{ str_replace(['https://', 'http://'], '', config('services.jitsi.server', 'https://meet.jit.si')) }}';
    var roomName = @json($session->jitsi_room_id);
    var displayName = @json(auth()->user()->name);

    new JitsiMeetExternalAPI(domain, {
        roomName: roomName,
        width: '100%',
        height: '100%',
        parentNode: document.querySelector('#jitsi-container'),
        userInfo: {
            displayName: displayName,
        },
        configOverwrite: {
            prejoinPageEnabled: false,
        },
        interfaceConfigOverwrite: {
            TOOLBAR_BUTTONS: [
                'microphone', 'camera', 'closedcaptions', 'desktop',
                'fullscreen', 'hangup', 'profile', 'chat', 'recording',
                'livestreaming', 'etherpad', 'sharedvideo', 'settings',
                'raisehand', 'videoquality', 'filmstrip', 'invite',
                'feedback', 'stats', 'shortcuts', 'tileview', 'videobackgroundblur',
                'download', 'help', 'mute-everyone', 'security', 'info'
            ],
            DEFAULT_LANGUAGE: 'en',
            SHOW_JITSI_WATERMARK: false,
        },
    });
});
</script>
@endpush