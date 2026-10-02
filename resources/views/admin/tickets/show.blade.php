@extends('layouts.app')

@section('title', 'Ticket ' . $ticket->ticket_number)
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <a href="{{ route('admin.tickets.index') }}" class="hover:text-primary">Tickets</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">{{ $ticket->ticket_number }}</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">{{ $ticket->subject }}</h1>
            <p class="text-slate-500 text-sm">{{ $ticket->ticket_number }} &middot; Opened by {{ $ticket->student->name ?? 'Unknown' }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Description</h2>
            <div class="text-sm text-slate-700 whitespace-pre-wrap">{{ $ticket->description }}</div>
        </div>

        <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
            <h2 class="font-semibold text-primary mb-4">Details</h2>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-slate-400 mb-1">Status</dt>
                    <dd>
                        @php
                            $statusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'in_progress' => 'bg-blue-100 text-blue-700', 'resolved' => 'bg-green-100 text-green-700', 'closed' => 'bg-slate-100 text-slate-500'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$ticket->status] ?? 'bg-slate-100 text-slate-500' }}">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Priority</dt>
                    <dd>
                        @php
                            $priorityColors = ['low' => 'bg-slate-100 text-slate-500', 'medium' => 'bg-blue-100 text-blue-700', 'high' => 'bg-orange-100 text-orange-700', 'urgent' => 'bg-red-100 text-red-700'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityColors[$ticket->priority] ?? 'bg-slate-100 text-slate-500' }}">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Category</dt>
                    <dd class="font-medium text-slate-800">{{ $ticket->category->name ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Assigned To</dt>
                    <dd class="font-medium text-slate-800">{{ $ticket->assignee->name ?? 'Unassigned' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-400 mb-1">Created</dt>
                    <dd class="font-medium text-slate-800">{{ $ticket->created_at->format('M d, Y H:i') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    {{-- Assign ticket --}}
    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6 mb-6">
        <h2 class="font-semibold text-primary mb-4">Assign Ticket</h2>
        <form action="{{ route('admin.tickets.assign', $ticket) }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-end">
            @csrf
            <div class="flex-1 w-full">
                <label for="assigned_to" class="block text-sm font-medium text-slate-700 mb-1">Assign to</label>
                <select name="assigned_to" id="assigned_to" required
                    class="w-full rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    @foreach($supportStaff as $staff)
                        <option value="{{ $staff->id }}" {{ $ticket->assigned_to == $staff->id ? 'selected' : '' }}>{{ $staff->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700 transition whitespace-nowrap">Assign</button>
        </form>
    </div>

    {{-- Responses --}}
    <div class="bg-white rounded-card shadow-sm border border-slate-100 p-6">
        <h2 class="font-semibold text-primary mb-4">Responses ({{ $ticket->responses->count() }})</h2>
        <div class="space-y-4">
            @forelse($ticket->responses as $response)
                <div class="border border-slate-100 rounded-card p-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-slate-800">{{ $response->user->name ?? 'System' }}</p>
                        <p class="text-xs text-slate-400">{{ $response->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <p class="text-sm text-slate-600 whitespace-pre-wrap">{{ $response->message }}</p>
                </div>
            @empty
                <x-empty-state title="No responses yet" message="Replies to this ticket will appear here." icon="chat" />
            @endforelse
        </div>
    </div>
@endsection