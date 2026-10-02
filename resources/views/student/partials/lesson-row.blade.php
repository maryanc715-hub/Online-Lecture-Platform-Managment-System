@php
    $isVideo = $material->type === 'video' && ($material->video_url || $material->file_path);
    $isComplete = $completedIds->contains($material->id);
@endphp
<li class="p-3 rounded-btn bg-slate-50 hover:bg-slate-100 transition">
    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 min-w-0">
            <div class="w-8 h-8 rounded-btn bg-secondary/10 flex items-center justify-center text-secondary flex-shrink-0">
                <div class="w-4 h-4">
                    @include('layouts.nav.icon', ['name' => $material->type === 'video' ? 'video' : 'document'])
                </div>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-medium {{ $isComplete ? 'text-slate-400 line-through' : 'text-slate-700' }} truncate">{{ $material->title }}</p>
                <p class="text-xs text-slate-400 capitalize">
                    {{ $material->type }}@if($material->category) &middot; {{ $material->category }} @endif
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 flex-shrink-0 ml-3">
            @if($isVideo)
                <button type="button"
                    onclick="toggleLectureVideo({{ $material->id }})"
                    class="inline-flex items-center gap-1 text-secondary hover:text-primary text-xs font-medium [&_svg]:w-3.5 [&_svg]:h-3.5">
                    @include('layouts.nav.icon', ['name' => 'play'])
                    Watch
                </button>
            @endif
            @if($material->file_path)
                <a href="{{ route('student.lectures.download', $material) }}" class="inline-flex items-center gap-1 text-secondary hover:text-primary text-xs font-medium [&_svg]:w-3.5 [&_svg]:h-3.5">
                    @include('layouts.nav.icon', ['name' => 'download'])
                    Download
                </a>
            @endif

            @if($isComplete)
                <form action="{{ route('student.lectures.uncomplete', $material) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" title="Mark as incomplete"
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-btn bg-green-600 text-white text-xs font-medium hover:bg-green-700 transition [&_svg]:w-3.5 [&_svg]:h-3.5">
                        @include('layouts.nav.icon', ['name' => 'check'])
                        Completed
                    </button>
                </form>
            @else
                <form action="{{ route('student.lectures.complete', $material) }}" method="POST">
                    @csrf
                    <button type="submit" title="Mark as complete"
                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-btn bg-white border border-slate-200 text-secondary text-xs font-medium hover:bg-secondary/10 transition [&_svg]:w-3.5 [&_svg]:h-3.5">
                        @include('layouts.nav.icon', ['name' => 'check'])
                        Mark Complete
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if($material->type === 'notes' && $material->notes)
        <div class="mt-3 rounded-btn bg-white border border-slate-200 p-4">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2 flex items-center gap-1.5">
                @include('layouts.nav.icon', ['name' => 'document'])
                Notes
            </p>
            <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $material->notes }}</div>
        </div>
    @endif

    @if($isVideo)
        <div id="lecture-video-{{ $material->id }}" class="hidden mt-3">
            @if($material->videoEmbedUrl())
                <div class="relative w-full max-w-[1280px] mx-auto aspect-video rounded-btn overflow-hidden bg-black">
                    <iframe data-src="{{ $material->videoEmbedUrl() }}" title="{{ $material->title }}"
                        class="absolute inset-0 w-full h-full border border-slate-200"
                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @else
                @php $videoFile = $material->videoFileUrl() ?? ($material->file_path ? asset('storage/'.$material->file_path) : null); @endphp
                @if($videoFile)
                    <video controls preload="metadata" class="w-full max-w-[1280px] mx-auto rounded-btn border border-slate-200 bg-black">
                        <source src="{{ $videoFile }}">
                        Your browser does not support the video tag.
                    </video>
                @endif
            @endif
            @if($material->description)
                <p class="text-xs text-slate-500 mt-2">{{ $material->description }}</p>
            @endif
        </div>
    @endif
</li>
