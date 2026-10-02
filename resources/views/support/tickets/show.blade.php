@extends('layouts.app')

@section('title', 'Ticket ' . $ticket->ticket_number)
@section('breadcrumbs')
    <a href="{{ route('support.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('support.tickets.index') }}" class="hover:text-primary">Tickets</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $ticket->ticket_number }}</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $ticket->subject }}</h1>
            <p class="text-slate-500 text-sm">Ticket {{ $ticket->ticket_number }} &middot; Created {{ $ticket->created_at->diffForHumans() }}</p>
        </div>
        <a href="{{ route('support.tickets.index') }}" class="px-4 py-2 rounded-btn border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50">
            Back to Tickets
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Ticket Details --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Ticket Info Card --}}
            <div class="bg-white rounded-card shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-primary">Ticket Details</h2>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-slate-500 mb-1">Student</p>
                            <p class="font-medium text-slate-800">{{ $ticket->student->name ?? '—' }}</p>
                            <p class="text-slate-400 text-xs">{{ $ticket->student->email ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500 mb-1">Category</p>
                            <p class="font-medium text-slate-800">{{ $ticket->category->name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500 mb-1">Priority</p>
                            @php
                                $priorityColors = [
                                    'low' => 'bg-slate-100 text-slate-600',
                                    'medium' => 'bg-amber-100 text-amber-700',
                                    'high' => 'bg-red-100 text-red-700',
                                    'urgent' => 'bg-red-200 text-red-800',
                                ];
                            @endphp
                            <span class="inline-block px-2 py-0.5 rounded-btn text-xs font-medium {{ $priorityColors[$ticket->priority] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-slate-500 mb-1">Status</p>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'in_progress' => 'bg-blue-100 text-blue-700',
                                    'resolved' => 'bg-secondary/10 text-secondary',
                                    'closed' => 'bg-slate-100 text-slate-500',
                                ];
                            @endphp
                            <span class="inline-block px-2 py-0.5 rounded-btn text-xs font-medium {{ $statusColors[$ticket->status] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-slate-500 mb-1">Assigned To</p>
                            <p class="font-medium text-slate-800">{{ $ticket->assignee->name ?? 'Unassigned' }}</p>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100">
                        <p class="text-slate-500 mb-2">Description</p>
                        <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-wrap">{{ $ticket->description }}</p>
                    </div>
                </div>
            </div>

            {{-- Response Form --}}
            <div class="bg-white rounded-card shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-primary">Add Response</h2>
                </div>
                <form action="{{ route('support.tickets.respond', $ticket) }}" method="POST" class="px-6 py-4">
                    @csrf
                    <div class="mb-4">
                        <textarea
                            name="message"
                            rows="4"
                            placeholder="Type your response..."
                            class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary resize-none"
                            required
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="px-5 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">
                        Send Response
                    </button>
                </form>
            </div>

            {{-- Responses List --}}
            <div class="bg-white rounded-card shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-primary">Responses ({{ $ticket->responses->count() }})</h2>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($ticket->responses as $response)
                    <div class="px-6 py-4">
                        <div class="flex items-start gap-3">
                            <img
                                src="{{ $response->user->avatar ? asset('storage/'.$response->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($response->user->name).'&background=1B4332&color=fff&size=32' }}"
                                class="w-8 h-8 rounded-full object-cover flex-shrink-0"
                                alt="{{ $response->user->name }}"
                            >
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-medium text-sm text-slate-800">{{ $response->user->name }}</span>
                                    <span class="text-xs text-slate-400 capitalize">{{ str_replace('_', ' ', $response->user->role->name ?? '') }}</span>
                                    <span class="text-xs text-slate-400">&middot;</span>
                                    <span class="text-xs text-slate-400">{{ $response->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-slate-700 whitespace-pre-wrap">{{ $response->message }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <x-empty-state title="No responses yet" message="Be the first to reply to this ticket." icon="chat" />
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Actions --}}
            <div class="bg-white rounded-card shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-primary">Actions</h2>
                </div>
                <div class="px-6 py-4 space-y-3">

                    {{-- Assign Self --}}
                    @if($ticket->assigned_to !== auth()->id())
                    <form action="{{ route('support.tickets.assign-self', $ticket) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 rounded-btn bg-secondary/10 text-secondary text-sm font-medium hover:bg-secondary/20 transition text-left flex items-center gap-2">
                            @include('layouts.nav.icon', ['name' => 'users'])
                            Assign to myself
                        </button>
                    </form>
                    @endif

                    {{-- Status Update --}}
                    <form action="{{ route('support.tickets.status', $ticket) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm text-slate-500 mb-1">Update Status</label>
                            <select name="status" class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                                @foreach(['pending', 'in_progress', 'resolved', 'closed'] as $status)
                                    <option value="{{ $status }}" {{ $ticket->status === $status ? 'selected' : '' }}>
                                        {{ str_replace('_', ' ', ucfirst($status)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full px-4 py-2.5 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            {{-- Ticket Meta --}}
            <div class="bg-white rounded-card shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-primary">Information</h2>
                </div>
                <div class="px-6 py-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Created</span>
                        <span class="text-slate-700">{{ $ticket->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Updated</span>
                        <span class="text-slate-700">{{ $ticket->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Responses</span>
                        <span class="text-slate-700">{{ $ticket->responses->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
