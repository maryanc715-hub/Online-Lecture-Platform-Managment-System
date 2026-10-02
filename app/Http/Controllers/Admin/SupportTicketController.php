<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = SupportTicket::with(['student', 'category', 'assignee'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->priority, fn ($q) => $q->where('priority', $request->priority))
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('ticket_number', 'like', "%{$request->search}%")
                  ->orWhere('subject', 'like', "%{$request->search}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load(['student', 'category', 'assignee', 'responses.user']);

        $supportStaff = User::whereHas('role', fn ($q) => $q->where('name', 'support_staff'))->get();

        return view('admin.tickets.show', compact('ticket', 'supportStaff'));
    }

    public function assign(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'assigned_to' => $validated['assigned_to'],
            'status' => $ticket->status === 'pending' ? 'in_progress' : $ticket->status,
        ]);

        Notification::notify(
            (string) $validated['assigned_to'],
            'ticket',
            'Ticket assigned to you',
            "{$ticket->ticket_number}: {$ticket->subject}"
        );

        ActivityLog::record('ticket.assigned', "Assigned ticket {$ticket->ticket_number}", $ticket);

        return back()->with('success', 'Ticket assigned successfully.');
    }
}
