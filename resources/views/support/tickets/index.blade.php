@extends('layouts.app')

@section('title', 'All Tickets')
@section('breadcrumbs')
    <a href="{{ route('support.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Tickets</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Support Tickets</h1>
            <p class="text-slate-500 text-sm">Manage and respond to student support requests.</p>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 mb-6">
        <div class="px-6 py-4 border-b border-slate-100">
            <form method="GET" class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-3 flex-1 min-w-56 rounded-btn border border-slate-200 bg-white px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                    <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                        @include('layouts.nav.icon', ['name' => 'search'])
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ticket # or subject..."
                        class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
                </div>
                <div>
                    <select name="status" class="rounded-btn border-slate-200 bg-slate-50 text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                        <option value="">All Statuses</option>
                        @foreach(['pending', 'in_progress', 'resolved', 'closed'] as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ str_replace('_', ' ', ucfirst($status)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">
                    Filter
                </button>
                @if(request('status') || request('search'))
                    <a href="{{ route('support.tickets.index') }}" class="px-4 py-2 rounded-btn border border-slate-200 text-sm text-slate-600 hover:bg-slate-50">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500 border-b border-slate-100">
                        <th class="px-6 py-3 font-medium">Ticket #</th>
                        <th class="px-6 py-3 font-medium">Student</th>
                        <th class="px-6 py-3 font-medium">Subject</th>
                        <th class="px-6 py-3 font-medium">Category</th>
                        <th class="px-6 py-3 font-medium">Priority</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-3">
                            <a href="{{ route('support.tickets.show', $ticket) }}" class="font-medium text-secondary hover:underline">
                                {{ $ticket->ticket_number }}
                            </a>
                        </td>
                        <td class="px-6 py-3 text-slate-700">{{ $ticket->student->name ?? '—' }}</td>
                        <td class="px-6 py-3 text-slate-700 max-w-xs truncate">{{ $ticket->subject }}</td>
                        <td class="px-6 py-3 text-slate-500">{{ $ticket->category->name ?? '—' }}</td>
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
                        <td colspan="7">
                            <x-empty-state title="No tickets found" message="Support tickets submitted by students will appear here." icon="ticket" />
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickets->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $tickets->withQueryString()->links() }}
        </div>
        @endif
    </div>

@endsection
