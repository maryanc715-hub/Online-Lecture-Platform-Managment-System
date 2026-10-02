@php
    $items = [
        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
        ['route' => 'admin.users.index', 'label' => 'Users', 'icon' => 'users'],
        ['route' => 'admin.courses.index', 'label' => 'Courses', 'icon' => 'book'],
        ['route' => 'admin.course-categories.index', 'label' => 'Categories', 'icon' => 'tag'],
        ['route' => 'admin.tickets.index', 'label' => 'Support Tickets', 'icon' => 'ticket'],
        ['route' => 'admin.announcements.index', 'label' => 'Announcements', 'icon' => 'megaphone'],
        ['route' => 'admin.roles.index', 'label' => 'Roles & Permissions', 'icon' => 'shield'],
        ['route' => 'admin.reports.index', 'label' => 'Reports', 'icon' => 'chart'],
        ['route' => 'admin.logs', 'label' => 'System Logs', 'icon' => 'clock'],
        ['route' => 'admin.backup', 'label' => 'Backup / Restore', 'icon' => 'database'],
        ['route' => 'admin.settings.edit', 'label' => 'Settings', 'icon' => 'cog'],
    ];
@endphp
@foreach($items as $item)
    <a href="{{ route($item['route']) }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-btn transition {{ request()->routeIs(str_replace('.index','',$item['route']).'*') ? 'bg-secondary text-white' : 'text-white/80 hover:bg-white/10' }}">
        @include('layouts.nav.icon', ['name' => $item['icon']])
        <span>{{ $item['label'] }}</span>
    </a>
@endforeach
