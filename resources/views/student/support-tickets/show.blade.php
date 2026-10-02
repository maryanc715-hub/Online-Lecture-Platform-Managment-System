@extends('layouts.app')

@section('title', 'Ticket ' . $ticket->ticket_number)
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('student.support-tickets.index') }}" class="hover:text-primary">Support Center</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $ticket->ticket_number }}</span>
@endsection

@section('content')

    <div class="max-w-3xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
            <div>
                <h1 class="text-2xl font-bold text-primary">{{ $ticket->subject }}</h1>
                <p class="text-slate-500 text-sm font-mono">{{ $ticket->ticket_number }}</p>
            </div>
            @if($ticket->status !== 'closed')
                <form action="{{ route('student.support-tickets.close', $ticket) }}" method="POST" onsubmit="return confirm('Are you sure you want to close this ticket?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-btn bg-red-50 border border-red-200 text-red-700 text-sm font-medium hover:bg-red-100 transition">
                        Close Ticket
                    </button>
                </form>
            @endif
        </div>

        {{-- Ticket Details --}}
        <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100 mb-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Status</p>
                    @if($ticket->status === 'closed')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-slate-100 text-slate-600">Closed</span>
                    @elseif($ticket->status === 'in_progress')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-blue-100 text-blue-700">In Progress</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-green-100 text-green-700">Open</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Priority</p>
                    @if($ticket->priority === 'high')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-red-100 text-red-700">High</span>
                    @elseif($ticket->priority === 'medium')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-yellow-100 text-yellow-700">Medium</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-slate-100 text-slate-600">Low</span>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Category</p>
                    <p class="text-sm font-medium text-slate-700">{{ $ticket->category->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Created</p>
                    <p class="text-sm font-medium text-slate-700">{{ $ticket->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <h3 class="text-sm font-semibold text-slate-700 mb-2">Description</h3>
                <p class="text-sm text-slate-600 leading-relaxed">{{ $ticket->description }}</p>
            </div>
        </div>

        {{-- Responses --}}
        <div class="bg-white rounded-card p-6 shadow-sm border border-slate-100">
            <h3 class="font-semibold text-primary mb-4">Responses ({{ $ticket->responses->count() }})</h3>

            @if($ticket->responses->isEmpty())
                <p class="text-slate-400 text-sm">No responses yet. Our team will get back to you soon.</p>
            @else
                <div class="space-y-4">
                    @foreach($ticket->responses as $response)
                        <div class="p-4 rounded-btn {{ $response->user_id === auth()->id() ? 'bg-primary/5 border border-primary/10 ml-8' : 'bg-slate-50 border border-slate-100 mr-8' }}">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full {{ $response->user_id === auth()->id() ? 'bg-primary text-white' : 'bg-secondary text-white' }} flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($response->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-slate-700">{{ $response->user->name ?? 'Unknown' }}</span>
                                </div>
                                <span class="text-xs text-slate-400">{{ $response->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $response->message }}</p>
                            @if($response->attachment)
                                <a href="{{ asset('storage/' . $response->attachment) }}" target="_blank" class="inline-flex items-center gap-1 mt-2 text-secondary hover:text-primary text-xs font-medium">
                                    <div class="w-3.5 h-3.5">
                                        @include('layouts.nav.icon', ['name' => 'attachment'])
                                    </div>
                                    Attachment
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection
