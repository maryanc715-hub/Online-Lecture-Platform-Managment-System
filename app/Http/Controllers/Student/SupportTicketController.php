<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SupportCategory;
use App\Models\SupportTicket;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('student_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('student.support-tickets.index', ['tickets' => $tickets]);
    }

    public function create()
    {
        $categories = SupportCategory::all();

        return view('student.support-tickets.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:support_categories,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket = SupportTicket::create([
            'student_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'pending',
        ]);

        User::whereHas('role', fn ($q) => $q->whereIn('name', ['support_staff', 'admin']))
            ->pluck('id')
            ->each(function ($userId) use ($ticket) {
                Notification::notify(
                    (string) $userId,
                    'ticket',
                    'New support ticket',
                    "{$ticket->ticket_number}: {$ticket->subject}"
                );
            });

        return redirect()->route('student.support-tickets.show', $ticket)
            ->with('success', 'Support ticket created successfully.');
    }

    public function show(SupportTicket $ticket)
    {
        if ((int) $ticket->student_id !== auth()->id()) {
            abort(403, 'You do not have access to this ticket.');
        }

        $ticket->load(['category', 'assignee', 'responses.user']);

        return view('student.support-tickets.show', ['ticket' => $ticket]);
    }

    public function close(SupportTicket $ticket)
    {
        if ((int) $ticket->student_id !== auth()->id()) {
            abort(403, 'You do not have access to this ticket.');
        }

        $ticket->update(['status' => 'closed']);

        return back()->with('success', 'Ticket has been closed.');
    }
}
