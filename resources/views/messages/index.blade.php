@extends('layouts.app')

@section('title', 'Messages')
@section('breadcrumbs')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Messages</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Messages</h1>
            <p class="text-slate-500 text-sm">Messages you have sent to and received from other platform users.</p>
        </div>
        <div class="flex items-center gap-3">
            <x-compose-message :users="$users" />
        </div>
    </div>

    @if($messages->isEmpty())
        <div class="bg-white rounded-card shadow-sm border border-slate-100">
            <x-empty-state title="No messages" message="You have no messages yet. Send a message to get started." icon="mail" />
        </div>
    @else
        <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">User</th>
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Subject</th>
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Status</th>
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($messages as $message)
                            @php
                                $isSent = $message->sender_id === auth()->id();
                                $otherParty = $isSent ? $message->receiver : $message->sender;
                                $isNew = ! $isSent && ! $message->is_read;
                            @endphp
                            <tr class="hover:bg-slate-50 transition cursor-pointer {{ $isNew ? 'bg-secondary/5 font-medium' : '' }}" onclick="window.location='{{ route('messages.show', $message) }}'">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center text-xs font-bold">
                                            {{ strtoupper(substr($otherParty->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-400">{{ $isSent ? 'To' : 'From' }}</p>
                                            <span class="text-slate-700">{{ $otherParty->name ?? 'Unknown' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-slate-700">{{ $message->subject ?: '(no subject)' }}</td>
                                <td class="px-5 py-4">
                                    @if($isNew)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-secondary/10 text-secondary">New</span>
                                    @elseif($isSent)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium {{ $message->is_read ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">{{ $message->is_read ? 'Sent · Read' : 'Sent' }}</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-slate-100 text-slate-600">Received</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-slate-500">{{ $message->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $messages->links() }}
        </div>
    @endif
@endsection
