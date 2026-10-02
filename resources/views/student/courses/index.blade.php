@extends('layouts.app')

@section('title', 'Courses')
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Courses</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">All Courses</h1>
            <p class="text-slate-500 text-sm">Browse available courses and enroll to start learning.</p>
        </div>
        <div class="text-sm text-slate-500">
            {{ $courses->count() }} {{ Str::plural('course', $courses->count()) }} available
        </div>
    </div>

    @if($courses->isEmpty())
        <div class="bg-white rounded-card shadow-sm border border-slate-100">
            <x-empty-state title="No courses available" message="No published courses are available right now. Check back later." icon="book" />
        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($courses as $course)
                @php $isEnrolled = $enrolledIds->contains($course->id); @endphp
                <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden flex flex-col hover:shadow-md transition">
                    {{-- Cover --}}
                    @if($course->thumbnail_url)
                        <div class="h-36 w-full overflow-hidden flex-shrink-0">
                            <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}"
                                class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="h-36 w-full bg-gradient-to-br from-secondary/90 to-primary/90 flex items-center justify-center flex-shrink-0">
                            <span class="text-4xl font-bold text-white/90">{{ strtoupper(substr($course->title, 0, 2)) }}</span>
                        </div>
                    @endif

                    {{-- Body --}}
                    <div class="p-5 flex flex-col flex-1">
                        <div class="flex items-center justify-between mb-2 gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">
                                {{ $course->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <h3 class="font-semibold text-primary text-lg leading-snug">{{ $course->title }}</h3>
                        <p class="text-slate-500 text-sm mt-1 line-clamp-2 flex-1">{{ $course->description ?? 'No description provided yet.' }}</p>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center text-xs font-bold flex-shrink-0">
                                {{ strtoupper(substr($course->instructor->name ?? '?', 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-slate-700 truncate">{{ $course->instructor->name ?? 'No instructor' }}</p>
                                <p class="text-xs text-slate-400">Instructor</p>
                            </div>
                            @if($course->duration)
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-500 flex-shrink-0 [&_svg]:w-4 [&_svg]:h-4">
                                    @include('layouts.nav.icon', ['name' => 'clock'])
                                    {{ $course->duration }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 pb-14 flex-shrink-0">
                        @if($isEnrolled)
                            <div class="flex items-center gap-2">
                                <a href="{{ route('student.courses.show', $course) }}"
                                    class="flex-1 text-center px-4 py-2 rounded-btn bg-secondary/10 text-secondary text-sm font-medium hover:bg-secondary/20 transition">
                                    Continue Learning
                                </a>
                                <form action="{{ route('student.courses.unenroll', $course) }}" method="POST">
                                    @csrf
                                    <button type="submit" title="Leave {{ $course->title }}"
                                        class="px-3 py-2 rounded-btn bg-red-50 text-red-600 text-sm font-medium hover:bg-red-100 transition flex items-center justify-center [&_svg]:w-4 [&_svg]:h-4"
                                        onclick="return confirm('Leave {{ $course->title }}?')">
                                        @include('layouts.nav.icon', ['name' => 'logout'])
                                    </button>
                                </form>
                            </div>
                        @else
                            <form action="{{ route('student.courses.enroll', $course) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition flex items-center justify-center gap-2 [&_svg]:w-4 [&_svg]:h-4">
                                    @include('layouts.nav.icon', ['name' => 'check'])
                                    Enroll in Course
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
