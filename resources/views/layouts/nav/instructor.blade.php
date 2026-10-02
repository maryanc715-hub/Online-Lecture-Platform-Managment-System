@php
    $items = [
        ['route' => 'instructor.dashboard', 'label' => 'Dashboard', 'icon' => 'home'],
        ['route' => 'instructor.students.index', 'label' => 'Students', 'icon' => 'users'],
        ['route' => 'instructor.courses.index', 'label' => 'My Courses', 'icon' => 'book'],
        ['route' => 'instructor.lectures.index', 'label' => 'Lecture Materials', 'icon' => 'document'],
        ['route' => 'instructor.modules.index', 'label' => 'Course Modules', 'icon' => 'menu'],
        ['route' => 'instructor.assignments.index', 'label' => 'Assignments', 'icon' => 'clipboard'],
        ['route' => 'instructor.live-sessions.index', 'label' => 'Live Sessions', 'icon' => 'video'],
        ['route' => 'instructor.progress.index', 'label' => 'Student Progress', 'icon' => 'chart'],
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
