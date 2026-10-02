@extends('layouts.app')

@section('title', 'Support Tickets')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Support Tickets</span>
@endsection

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Support Tickets</h1>
            <p class="text-slate-500 text-sm">Manage and assign user support tickets.</p>
        </div>
    </div>

    <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-4 border-b border-slate-100 bg-slate-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex items-center gap-3 flex-1 rounded-btn border border-slate-200 bg-white px-4 focus-within:ring-2 focus-within:ring-secondary focus-within:border-secondary">
                    <span class="flex items-center justify-center text-slate-400 flex-shrink-0 [&_svg]:w-5 [&_svg]:h-5">
                        @include('layouts.nav.icon', ['name' => 'search'])
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ticket # or subject..."
                        class="flex-1 min-w-0 border-0 bg-transparent py-2 pr-1 text-sm text-slate-900 placeholder:text-slate-400 focus:ring-0 focus:outline-none">
                </div>
                <select name="status" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Status</option>
                    @foreach(['pending', 'in_progress', 'resolved', 'closed'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                    @endforeach
                </select>
                <select name="priority" class="rounded-btn border-slate-200 bg-white text-sm focus:ring-2 focus:ring-secondary focus:border-secondary">
                    <option value="">All Priority</option>
                    @foreach(['low', 'medium', 'high', 'urgent'] as $priority)
                        <option value="{{ $priority }}" {{ request('priority') === $priority ? 'selected' : '' }}>{{ ucfirst($priority) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/60">
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Ticket</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Student</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Category</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Priority</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Status</th>
                        <th class="text-left px-6 py-3 font-semibold text-slate-600">Assignee</th>
                        <th class="text-right px-6 py-3 font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-800">{{ $ticket->ticket_number }}</p>
                                <p class="text-slate-400 text-xs">{{ Str::limit($ticket->subject, 40) }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $ticket->student->name ?? '—' }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $ticket->category->name ?? '—' }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $priorityColors = ['low' => 'bg-slate-100 text-slate-500', 'medium' => 'bg-blue-100 text-blue-700', 'high' => 'bg-orange-100 text-orange-700', 'urgent' => 'bg-red-100 text-red-700'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityColors[$ticket->priority] ?? 'bg-slate-100 text-slate-500' }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusColors = ['pending' => 'bg-yellow-100 text-yellow-700', 'in_progress' => 'bg-blue-100 text-blue-700', 'resolved' => 'bg-green-100 text-green-700', 'closed' => 'bg-slate-100 text-slate-500'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$ticket->status] ?? 'bg-slate-100 text-slate-500' }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $ticket->assignee->name ?? 'Unassigned' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.tickets.show', $ticket) }}" class="px-3 py-1.5 rounded-btn bg-secondary/10 text-secondary text-xs font-medium hover:bg-secondary/20 transition">View</a>
                            </td>
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
    </div>

    <div class="mt-6">
        {{ $tickets->links() }}
    </div>
@endsection