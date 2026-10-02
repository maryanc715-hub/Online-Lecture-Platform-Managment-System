@props(['users'])

@php
    $hasErrors = $errors->hasAny(['receiver_id', 'subject', 'body', 'attachment']);
    $oldRecipient = old('receiver_id');
@endphp

<div
    x-data="{ open: @js($hasErrors) }"
    x-effect="document.body.classList.toggle('overflow-hidden', open)"
    x-init="$watch('open', (value) => { if (value) $nextTick(() => $refs.body?.focus()) })"
    @keydown.escape.window="open = false"
>
    <button
        type="button"
        @click="open = true"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition"
    >
        <span class="w-4 h-4">@include('layouts.nav.icon', ['name' => 'pencil'])</span>
        New Message
    </button>

    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
        role="dialog"
        aria-modal="true"
        aria-labelledby="compose-message-title"
    >
        <div class="absolute inset-0" @click="open = false" aria-hidden="true"></div>

        <div
            @click.stop
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto bg-white rounded-card shadow-xl"
        >
            <div class="flex items-center justify-between gap-4 px-6 py-4 border-b border-slate-100">
                <h2 id="compose-message-title" class="font-semibold text-primary">New Message</h2>
                <button
                    type="button"
                    @click="open = false"
                    aria-label="Close"
                    class="p-1.5 rounded-btn text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition"
                >
                    <span class="block w-4 h-4">@include('layouts.nav.icon', ['name' => 'close'])</span>
                </button>
            </div>

            <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data" class="px-6 py-5">
                @csrf

                <div class="mb-4">
                    <label for="compose-receiver_id" class="block text-sm font-medium text-slate-700 mb-1">Recipient</label>
                    <select name="receiver_id" id="compose-receiver_id" required
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        <option value="">Select a user...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected((int) $oldRecipient === $user->id)>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('receiver_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="compose-subject" class="block text-sm font-medium text-slate-700 mb-1">Subject <span class="text-slate-400">(optional)</span></label>
                    <input type="text" name="subject" id="compose-subject" value="{{ old('subject') }}"
                        placeholder="Message subject"
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="compose-body" class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                    <textarea name="body" id="compose-body" rows="6" x-ref="body" required
                        placeholder="Write your message..."
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="compose-attachment" class="block text-sm font-medium text-slate-700 mb-1">Attachment <span class="text-slate-400">(optional)</span></label>
                    <input type="file" name="attachment" id="compose-attachment"
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary file:mr-3 file:py-1.5 file:px-3 file:rounded-btn file:border-0 file:text-sm file:font-medium file:bg-secondary/10 file:text-secondary hover:file:bg-secondary/20">
                    @error('attachment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50 transition">Cancel</button>
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">
                        <span class="w-4 h-4">@include('layouts.nav.icon', ['name' => 'send'])</span>
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
