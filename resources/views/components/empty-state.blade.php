@props(['title', 'message', 'icon' => 'document', 'action' => null, 'actionUrl' => null])
<div class="py-12 px-6 text-center">
    <div class="w-12 h-12 mx-auto mb-4 rounded-btn bg-secondary/10 flex items-center justify-center text-secondary">
        <div class="w-6 h-6">
            @include('layouts.nav.icon', ['name' => $icon])
        </div>
    </div>
    <h3 class="text-base font-semibold text-slate-700">{{ $title }}</h3>
    <p class="text-sm text-slate-500 mt-1">{{ $message }}</p>
    @if($action && $actionUrl)
        <a href="{{ $actionUrl }}" class="mt-5 inline-flex px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">{{ $action }}</a>
    @endif
</div>
