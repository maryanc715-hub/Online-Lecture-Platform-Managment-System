@php
    $items = [
        ['route' => 'support.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
        ['route' => 'support.tickets.index', 'label' => 'Support Tickets', 'icon' => 'ticket'],
        ['route' => 'messages.index', 'label' => 'Messages', 'icon' => 'chat'],
    ];
@endphp
@foreach($items as $item)
    <a href="{{ route($item['route']) }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-btn transition {{ request()->routeIs(str_replace('.index','',$item['route']).'*') ? 'bg-secondary text-white' : 'text-white/80 hover:bg-white/10' }}">
        @include('layouts.nav.icon', ['name' => $item['icon']])
        <span>{{ $item['label'] }}</span>
    </a>
@endforeach
