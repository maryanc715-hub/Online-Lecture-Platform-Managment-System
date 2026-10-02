<?php

namespace App\Http\Controllers\SupportStaff;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $totalAssigned = SupportTicket::where('assigned_to', $userId)->count();

        $pendingCount = SupportTicket::where(function ($q) use ($userId) {
            $q->where('assigned_to', $userId)->orWhereNull('assigned_to');
        })->where('status', 'pending')->count();

        $inProgressCount = SupportTicket::where('assigned_to', $userId)
            ->where('status', 'in_progress')->count();

        $resolvedCount = SupportTicket::where('assigned_to', $userId)
            ->where('status', 'resolved')->count();

        $recentTickets = SupportTicket::with(['student', 'category', 'assignee'])
            ->latest()
            ->limit(10)
            ->get();

        return view('support.dashboard', compact(
            'totalAssigned',
            'pendingCount',
            'inProgressCount',
            'resolvedCount',
            'recentTickets',
        ));
    }
}
