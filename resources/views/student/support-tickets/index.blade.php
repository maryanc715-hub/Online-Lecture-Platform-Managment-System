@extends('layouts.app')

@section('title', 'Support Center')
@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}" class="hover:text-primary">Dashboard</a>
    <span class="mx-1">/</span>
    <span class="font-medium text-primary">Support Center</span>
@endsection

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-primary">Support Center</h1>
            <p class="text-slate-500 text-sm">Manage your support tickets and get help.</p>
        </div>
        <a href="{{ route('student.support-tickets.create') }}" class="px-4 py-2 rounded-btn bg-primary text-white text-sm font-medium hover:bg-primary-700">
            + New Ticket
        </a>
    </div>

    @if($tickets->isEmpty())
        <div class="bg-white rounded-card shadow-sm border border-slate-100">
            <x-empty-state title="No tickets yet" message="You haven't created any support tickets." icon="ticket" action="Create Your First Ticket" :actionUrl="route('student.support-tickets.create')" />
        </div>
    @else
        <div class="bg-white rounded-card shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/60">
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Ticket #</th>
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Subject</th>
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Category</th>
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Priority</th>
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Status</th>
                            <th class="text-left px-5 py-3 font-semibold text-slate-600">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-slate-50 transition cursor-pointer" onclick="window.location='{{ route('student.support-tickets.show', $ticket) }}'">
                                <td class="px-5 py-4 font-mono text-xs text-slate-500">{{ $ticket->ticket_number }}</td>
                                <td class="px-5 py-4 font-medium text-slate-700">{{ $ticket->subject }}</td>
                                <td class="px-5 py-4 text-slate-500">{{ $ticket->category->name ?? 'N/A' }}</td>
                                <td class="px-5 py-4">
                                    @if($ticket->priority === 'high')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-red-100 text-red-700">High</span>
                                    @elseif($ticket->priority === 'medium')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-yellow-100 text-yellow-700">Medium</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-slate-100 text-slate-600">Low</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4">
                                    @if($ticket->status === 'closed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-slate-100 text-slate-600">Closed</span>
                                    @elseif($ticket->status === 'in_progress')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-blue-100 text-blue-700">In Progress</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-btn text-xs font-medium bg-green-100 text-green-700">Open</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-slate-500">{{ $ticket->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $tickets->links() }}
        </div>
    @endif

@endsection
