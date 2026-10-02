@php
    $items = [
        ['route' => 'student.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
        ['route' => 'student.courses.index', 'label' => 'My Courses', 'icon' => 'book'],
        ['route' => 'student.assignments.index', 'label' => 'Assignments', 'icon' => 'clipboard'],
        ['route' => 'student.grades.index', 'label' => 'Grades', 'icon' => 'award'],
        ['route' => 'student.live-sessions.index', 'label' => 'Live Sessions', 'icon' => 'video'],
        ['route' => 'student.progress.index', 'label' => 'Academic Progress', 'icon' => 'chart'],
        ['route' => 'messages.index', 'label' => 'Messages', 'icon' => 'chat'],
        ['route' => 'student.support-tickets.index', 'label' => 'Support Center', 'icon' => 'ticket'],
    ];
@endphp
@foreach($items as $item)
    <a href="{{ route($item['route']) }}"
       class="flex items-center gap-3 px-3 py-2.5 rounded-btn transition {{ request()->routeIs(str_replace('.index','',$item['route']).'*') ? 'bg-secondary text-white' : 'text-white/80 hover:bg-white/10' }}">
        @include('layouts.nav.icon', ['name' => $item['icon']])
        <span>{{ $item['label'] }}</span>
    </a>
@endforeach
