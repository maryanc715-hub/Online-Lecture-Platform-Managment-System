<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number', 'student_id', 'category_id', 'assigned_to',
        'subject', 'description', 'priority', 'status',
    ];

    protected static function booted()
    {
        static::creating(function ($ticket) {
            $ticket->ticket_number = $ticket->ticket_number ?: static::generateTicketNumber();
        });
    }

    public static function generateTicketNumber(): string
    {
        do {
            $number = 'TKT-' . now()->format('ymd') . '-' . strtoupper(Str::random(5));
        } while (static::where('ticket_number', $number)->exists());

        return $number;
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function category()
    {
        return $this->belongsTo(SupportCategory::class, 'category_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function responses()
    {
        return $this->hasMany(TicketResponse::class, 'ticket_id');
    }
}
