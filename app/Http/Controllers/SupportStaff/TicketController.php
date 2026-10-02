<?php

namespace App\Http\Controllers\SupportStaff;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketResponse;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = SupportTicket::with(['student', 'category', 'assignee'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->search, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('ticket_number', 'like', "%{$request->search}%")
                  ->orWhere('subject', 'like', "%{$request->search}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('support.tickets.index', compact('tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load(['student', 'category', 'assignee', 'responses.user']);

        return view('support.tickets.show', compact('ticket'));
    }

    public function respond(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        TicketResponse::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        Notification::notify(
            (string) $ticket->student_id,
            'ticket',
            'Ticket response',
            "Support replied to {$ticket->ticket_number}: " . Str::limit($validated['message'], 80)
        );

        if ($ticket->status === 'pending') {
            $ticket->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Response sent successfully.');
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed',
        ]);

        $ticket->update(['status' => $validated['status']]);

        return back()->with('success', 'Ticket status updated successfully.');
    }

    public function assignSelf(SupportTicket $ticket)
    {
        $ticket->update([
            'assigned_to' => auth()->id(),
            'status' => 'in_progress',
        ]);

        return back()->with('success', 'You have been assigned to this ticket.');
    }
}
