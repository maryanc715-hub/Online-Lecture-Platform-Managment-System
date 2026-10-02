<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('notifications')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at');

        if ($request->boolean('unread_count')) {
            $count = (clone $query)->whereNull('read_at')->count();

            return response()->json(['count' => $count]);
        }

        $notifications = $query->paginate(20)->withQueryString();

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(string $id)
    {
        $updated = DB::table('notifications')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        abort_unless($updated, 404);

        return back()->with('success', 'Notification marked as read.');
    }
}
