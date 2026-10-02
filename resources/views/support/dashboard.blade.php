@extends('layouts.app')

@section('title', 'Support Dashboard')
@section('breadcrumbs')
    <span class="font-medium text-primary">Dashboard</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Welcome back, {{ explode(' ', auth()->user()->name)[0] }}</h1>
            <p class="text-slate-500 text-sm">Here's your support dashboard overview.</p>
        </div>
        <a href="{{ route('support.tickets.index') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">
            View All Tickets
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'Total Assigned', 'value' => $totalAssigned, 'icon' => 'ticket'],
            ['label' => 'Pending', 'value' => $pendingCount, 'icon' => 'clock'],
            ['label' => 'In Progress', 'value' => $inProgressCount, 'icon' => 'clipboard'],
            ['label' => 'Resolved', 'value' => $resolvedCount, 'icon' => 'shield'],
        ] as $card)
        <div class="bg-white rounded-card p-5 shadow-sm border border-slate-100 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-btn bg-secondary/10 flex items-center justify-center text-secondary">
                    @include('layouts.nav.icon', ['name' => $card['icon']])
                </div>
            </div>
            <p class="text-2xl font-bold text-primary">{{ $card['value'] }}</p>
            <p class="text-slate-500 text-sm">{{ $card['label'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-semibold text-primary">Recent Tickets</h2>
            <a href="{{ route('support.tickets.index') }}" class="text-sm text-secondary hover:underline">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500 border-b border-slate-100">
                        <th class="px-6 py-3 font-medium">Ticket #</th>
                        <th class="px-6 py-3 font-medium">Student</th>
                        <th class="px-6 py-3 font-medium">Subject</th>
                        <th class="px-6 py-3 font-medium">Priority</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentTickets as $ticket)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-3">
                            <a href="{{ route('support.tickets.show', $ticket) }}" class="font-medium text-secondary hover:underline">
                                {{ $ticket->ticket_number }}
                            </a>
                        </td>
                        <td class="px-6 py-3 text-slate-700">{{ $ticket->student->name ?? '—' }}</td>
                        <td class="px-6 py-3 text-slate-700 max-w-xs truncate">{{ $ticket->subject }}</td>
                        <td class="px-6 py-3">
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
                        </td>
                        <td class="px-6 py-3">
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
                        </td>
                        <td class="px-6 py-3 text-slate-500 text-xs">{{ $ticket->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <x-empty-state title="No tickets found" message="Support tickets submitted by students will appear here." icon="ticket" />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
