@extends('layouts.app')

@section('title', 'Message')
@section('breadcrumbs')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('messages.index') }}" class="hover:text-primary">Messages</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">View</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $message->subject ?: '(no subject)' }}</h1>
            <p class="text-slate-500 text-sm">
                From <span class="font-medium text-slate-700">{{ $message->sender->name ?? 'Unknown' }}</span>
                to <span class="font-medium text-slate-700">{{ $message->receiver->name ?? 'Unknown' }}</span>
                &middot; {{ $message->created_at->format('M d, Y g:i A') }}
            </p>
        </div>
        <a href="{{ route('messages.index') }}" class="px-4 py-2 rounded-btn bg-white border border-slate-200 text-sm font-medium hover:bg-slate-50">Back to Messages</a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Message</h2>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center font-bold">
                    {{ strtoupper(substr($message->sender->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">{{ $message->sender->name ?? 'Unknown' }}</p>
                    <p class="text-xs text-slate-400">{{ $message->sender->email ?? '' }}</p>
                </div>
            </div>

            <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line mb-6">{{ $message->body }}</div>

            @if($message->attachment)
                <a href="{{ route('messages.attachment', $message) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-btn bg-secondary/10 text-secondary text-sm font-medium hover:bg-secondary/20 transition">
                    <div class="w-4 h-4">
                        @include('layouts.nav.icon', ['name' => 'download'])
                    </div>
                    Download Attachment
                </a>
            @endif
        </div>

        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Reply</h2>
            @php
                $otherParty = auth()->id() === $message->sender_id ? $message->receiver : $message->sender;
            @endphp
            <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $otherParty->id }}">
                <input type="hidden" name="subject" value="Re: {{ $message->subject ?: '(no subject)' }}">
                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                    <textarea name="body" id="body" rows="5" required placeholder="Write your reply..."
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary"></textarea>
                    @error('body')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="attachment" class="block text-sm font-medium text-slate-700 mb-1">Attachment <span class="text-slate-400">(optional)</span></label>
                    <input type="file" name="attachment" id="attachment"
                        class="w-full rounded-btn border-slate-200 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary file:mr-3 file:py-1.5 file:px-3 file:rounded-btn file:border-0 file:text-sm file:font-medium file:bg-secondary/10 file:text-secondary hover:file:bg-secondary/20">
                    @error('attachment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">Send Reply</button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
        <h2 class="font-semibold text-primary mb-4">New Message</h2>
        <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid sm:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="receiver_id" class="block text-sm font-medium text-slate-700 mb-1">Recipient</label>
                    <select name="receiver_id" id="receiver_id" required
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        <option value="">Select a user...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    @error('receiver_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-slate-700 mb-1">Subject <span class="text-slate-400">(optional)</span></label>
                    <input type="text" name="subject" id="subject" placeholder="Message subject"
                        class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mb-4">
                <label for="new_body" class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                <textarea name="body" id="new_body" rows="4" required placeholder="Write your message..."
                    class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary"></textarea>
                @error('body')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end gap-3">
                <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">Send Message</button>
            </div>
        </form>
    </div>
@endsection
