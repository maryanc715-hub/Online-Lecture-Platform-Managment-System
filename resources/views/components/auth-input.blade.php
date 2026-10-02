@props([
    'label',
    'name',
    'type' => 'text',
    'icon' => 'user',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'autofocus' => false,
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-2">{{ $label }}</label>
    <div class="flex items-center gap-3 w-full rounded-btn border border-slate-200 bg-slate-50 px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
        <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
            @include('layouts.nav.icon', ['name' => $icon])
        </span>
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            @if($autofocus) autofocus @endif
            {{ $attributes->merge(['class' => 'flex-1 min-w-0 border-0 bg-transparent py-3 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none']) }}
        />
    </div>
</div>
