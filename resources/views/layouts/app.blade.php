<!DOCTYPE html>
<html lang="en" x-data="{ dark: false, sidebarOpen: false }" :class="{ 'dark': dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Online Lecture Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-surface/40 text-slate-800">

    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-40 w-64 bg-primary text-white transform transition-transform duration-300 lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen lg:flex lg:flex-col"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="h-16 flex items-center px-6 border-b border-white/10">
                <span class="font-bold text-lg tracking-tight">Lecture Platform</span>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-6 space-y-1 text-sm">
                @php $role = auth()->user()->role->name; @endphp

                @if($role === 'admin')
                    @include('layouts.nav.admin')
                @elseif($role === 'instructor')
                    @include('layouts.nav.instructor')
                @elseif($role === 'student')
                    @include('layouts.nav.student')
                @elseif($role === 'support_staff')
                    @include('layouts.nav.support')
                @endif
            </nav>

            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center gap-2 px-3 py-2 rounded-btn text-sm hover:bg-white/10 transition">
                        @include('layouts.nav.icon', ['name' => 'logout'])
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            {{-- Topbar --}}
            <header class="h-16 bg-white/80 backdrop-blur border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-btn hover:bg-slate-100">
                        @include('layouts.nav.icon', ['name' => 'menu'])
                    </button>
                    <nav class="hidden sm:flex text-sm text-slate-500 gap-1">
                        @yield('breadcrumbs')
                    </nav>
                </div>

                <form action="{{ route('search') }}" class="hidden md:block flex-1 max-w-md mx-6">
                    <div class="flex items-center gap-3 w-full rounded-btn border border-slate-200 bg-slate-50 px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                        <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                            @include('layouts.nav.icon', ['name' => 'search'])
                        </span>
                        <input type="search" name="q" placeholder="Search courses, students, assignments..."
                            class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
                    </div>
                </form>

                <div class="flex items-center gap-3">
                    <a href="{{ route('notifications.index') }}" class="relative p-2 rounded-btn hover:bg-slate-100">
                        <div class="w-6 h-6 text-primary">
                            @include('layouts.nav.icon', ['name' => 'bell'])
                        </div>
                        @if(auth()->user()->notifications()->whereNull('read_at')->exists())
                            <span class="absolute top-1 right-1 w-2.5 h-2.5 rounded-full bg-red-500 border-2 border-white"></span>
                        @endif
                    </a>
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=1B4332&color=fff' }}"
                                class="w-9 h-9 rounded-full object-cover" alt="{{ auth()->user()->name }}">
                            @if(auth()->user()->notifications()->whereNull('read_at')->exists())
                                <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-red-500 border-2 border-white"></span>
                            @endif
                        </div>
                        <div class="hidden sm:block text-sm">
                            <p class="font-semibold leading-tight">{{ auth()->user()->name }}</p>
                            <p class="text-slate-400 text-xs capitalize">{{ str_replace('_',' ', $role) }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 rounded-card bg-secondary/10 border border-secondary/30 text-primary px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 rounded-card bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('warning'))
                    <div class="mb-6 rounded-card bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 text-sm">
                        {{ session('warning') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
