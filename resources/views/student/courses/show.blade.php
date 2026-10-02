@extends('layouts.app')

@section('title', $course->title)
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('student.courses.index') }}" class="hover:text-primary">My Courses</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $course->title }}</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div class="flex items-start gap-4">
            @if($course->thumbnail_url)
                <img src="{{ $course->thumbnail_url }}" alt="" class="h-16 w-24 rounded-card object-cover border border-slate-200 flex-shrink-0">
            @endif
            <div>
            <h1 class="text-2xl font-bold text-primary">{{ $course->title }}</h1>
            <p class="text-slate-500 text-sm">
                Instructor: {{ $course->instructor->name ?? 'N/A' }}
                @if($course->category) <span class="mx-1">&middot;</span> {{ $course->category->name }} @endif
                @if($course->duration) <span class="mx-1">&middot;</span> {{ $course->duration }} @endif
            </p>
            @if($course->description)
                <p class="text-slate-600 text-sm mt-2">{{ $course->description }}</p>
            @endif
            </div>
        </div>
    </div>

    {{-- Progress line --}}
    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
            <div class="flex-shrink-0 text-center sm:text-left">
                <p class="text-3xl font-bold text-primary">{{ $completionPercent }}%</p>
                <p class="text-xs text-slate-400 mt-1">Course progress</p>
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between text-xs mb-2">
                    <span class="font-medium text-slate-600">{{ $completedCount }} of {{ $totalLessons }} lessons completed</span>
                    @if($totalLessons > 0 && $completionPercent === 100)
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 [&_svg]:w-3.5 [&_svg]:h-3.5">
                            @include('layouts.nav.icon', ['name' => 'check'])
                            Course Completed
                        </span>
                    @endif
                </div>
                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-secondary to-primary rounded-full h-3 transition-all duration-500" style="width: {{ $completionPercent }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Course Content --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-semibold text-primary">Course Content</h2>
                    <span class="text-xs text-slate-400">{{ $completedCount }}/{{ $totalLessons }} lessons</span>
                </div>

                @if($totalLessons === 0)
                    <p class="text-slate-400 text-sm py-6 text-center">No course content available yet.</p>
                @else
                    @foreach($course->lectureModules as $module)
                        @php
                            $moduleLessons = $module->lectureMaterials;
                            $moduleTotal = $moduleLessons->count();
                            $moduleCompleted = $moduleLessons->filter(fn ($m) => $completedIds->contains($m->id))->count();
                            $modulePct = $moduleTotal > 0 ? round($moduleCompleted / $moduleTotal * 100) : 0;
                        @endphp
                        <div class="mb-6 last:mb-0">
                            <button type="button"
                                onclick="toggleModuleLessons({{ $module->id }})"
                                class="w-full flex items-start gap-3 mb-3 text-left group {{ $moduleLessons->isEmpty() ? 'cursor-default' : 'cursor-pointer' }}">
                                <div class="w-9 h-9 rounded-btn bg-primary/10 flex items-center justify-center text-primary font-bold text-xs flex-shrink-0">{{ $module->sort_order }}</div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-primary text-sm group-hover:text-primary-700">{{ $module->title }}</h3>
                                    @if($module->description)
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $module->description }}</p>
                                    @endif
                                    <div class="mt-2 module-progress">
                                        <div class="flex items-center justify-between text-xs mb-1">
                                            <span class="text-slate-400">{{ $moduleCompleted }}/{{ $moduleTotal }} completed</span>
                                            <span class="font-semibold text-primary">{{ $modulePct }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                                            <div class="bg-secondary rounded-full h-1.5 transition-all duration-500" style="width: {{ $modulePct }}%"></div>
                                        </div>
                                    </div>
                                </div>
                                @if($moduleLessons->isNotEmpty())
                                    <div class="flex-shrink-0 pt-1">
                                        <span class="module-chevron inline-flex text-slate-400 group-hover:text-secondary transition-transform duration-300 rotate-180 [&_svg]:w-4 [&_svg]:h-4">
                                            @include('layouts.nav.icon', ['name' => 'chevron-down'])
                                        </span>
                                    </div>
                                @endif
                            </button>
                            @if($moduleLessons->isEmpty())
                                <p class="text-slate-400 text-sm">No lessons in this module yet.</p>
                            @else
                                <div id="module-lessons-{{ $module->id }}">
                                    <ul class="space-y-2">
                                        @foreach($moduleLessons as $material)
                                            @include('student.partials.lesson-row', ['material' => $material])
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    @php $ungrouped = $course->lectureMaterials->whereNull('module_id'); @endphp
                    @if($ungrouped->count())
                        <div>
                            <button type="button"
                                onclick="toggleModuleLessons('ungrouped')"
                                class="w-full flex items-center justify-between mb-3 text-left group cursor-pointer">
                                <h3 class="font-semibold text-primary text-sm">General</h3>
                                <span class="module-chevron inline-flex text-slate-400 group-hover:text-secondary transition-transform duration-300 rotate-180 [&_svg]:w-4 [&_svg]:h-4">
                                    @include('layouts.nav.icon', ['name' => 'chevron-down'])
                                </span>
                            </button>
                            <div id="module-lessons-ungrouped">
                                <ul class="space-y-2">
                                    @foreach($ungrouped as $material)
                                        @include('student.partials.lesson-row', ['material' => $material])
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- Assignments --}}
        <div class="space-y-6">
            <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
                <h2 class="font-semibold text-primary mb-4">Assignments</h2>
                @if($course->assignments->isEmpty())
                    <p class="text-slate-400 text-sm">No assignments posted yet.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($course->assignments as $assignment)
                            <li class="p-3 rounded-btn bg-slate-50 hover:bg-slate-100 transition">
                                <a href="{{ route('student.assignments.show', $assignment) }}" class="block">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-slate-700">{{ $assignment->title }}</p>
                                        @if($assignment->isOverdue())
                                            <span class="text-xs font-medium text-red-600 bg-red-50 px-2 py-0.5 rounded-btn">Overdue</span>
                                        @else
                                            <span class="text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded-btn">Due {{ $assignment->due_date->format('M d') }}</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-slate-400 mt-1">{{ $assignment->total_marks }} marks</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        function toggleLectureVideo(id) {
            const el = document.getElementById('lecture-video-' + id);
            if (!el) return;
            el.classList.toggle('hidden');
            const iframe = el.querySelector('iframe[data-src]');
            if (iframe && !iframe.getAttribute('src') && !el.classList.contains('hidden')) {
                iframe.setAttribute('src', iframe.getAttribute('data-src'));
            }
            const video = el.querySelector('video');
            if (video) {
                if (el.classList.contains('hidden')) { video.pause(); }
                else { video.play().catch(() => {}); }
            }
        }

        function toggleModuleLessons(id) {
            const el = document.getElementById('module-lessons-' + id);
            if (!el) return;
            const isCollapsing = !el.classList.contains('hidden');
            el.classList.toggle('hidden');
            const chevron = el.closest('div').parentElement.querySelector('.module-chevron');
            if (chevron) {
                chevron.classList.toggle('rotate-180');
            }
            if (isCollapsing) {
                el.querySelectorAll('video').forEach(v => v.pause());
                el.querySelectorAll('iframe[data-src]').forEach(f => f.removeAttribute('src'));
                el.querySelectorAll('[id^="lecture-video-"]:not(.hidden)').forEach(v => v.classList.add('hidden'));
            }
            const progress = el.closest('div').parentElement.querySelector('.module-progress');
            if (progress) {
                progress.classList.toggle('hidden', isCollapsing);
            }
        }
    </script>
@endpush
