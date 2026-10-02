<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = Message::with(['sender', 'receiver'])
            ->where(function ($query) {
                $query->where('receiver_id', auth()->id())
                    ->orWhere('sender_id', auth()->id());
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('messages.index', [
            'messages' => $messages,
            'users' => $this->recipients(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'attachment' => 'nullable|file|max:5120',
        ]);

        abort_if((int) $validated['receiver_id'] === auth()->id(), 422, 'You cannot send a message to yourself.');

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('message-attachments', 'public');
        }

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'subject' => $validated['subject'] ?? null,
            'body' => $validated['body'],
            'attachment' => $validated['attachment'] ?? null,
        ]);

        Notification::notify(
            (string) $message->receiver_id,
            'message',
            'New message',
            auth()->user()->name . ' sent you a message: ' . Str::limit($message->body, 80)
        );

        ActivityLog::record('message.sent', "Sent message to user #{$message->receiver_id}", $message);

        return redirect()->route('messages.index')->with('success', 'Message sent successfully.');
    }

    public function show(Message $message)
    {
        abort_unless(
            $message->sender_id === auth()->id() || $message->receiver_id === auth()->id(),
            403
        );

        if ($message->receiver_id === auth()->id() && ! $message->is_read) {
            $message->update(['is_read' => true, 'read_at' => now()]);
        }

        $message->load(['sender', 'receiver']);

        return view('messages.show', [
            'message' => $message,
            'users' => $this->recipients(),
        ]);
    }

    public function downloadAttachment(Message $message)
    {
        abort_unless(
            $message->sender_id === auth()->id() || $message->receiver_id === auth()->id(),
            403
        );

        if (! $message->attachment || ! Storage::disk('public')->exists($message->attachment)) {
            abort(404, 'File not found.');
        }

        $extension = pathinfo($message->attachment, PATHINFO_EXTENSION);
        $name = (Str::slug($message->subject ?: 'attachment', '_') ?: 'attachment') . '.' . $extension;

        return Storage::disk('public')->download($message->attachment, $name);
    }

    private function recipients()
    {
        return User::where('id', '!=', auth()->id())->orderBy('name')->get();
    }
}
