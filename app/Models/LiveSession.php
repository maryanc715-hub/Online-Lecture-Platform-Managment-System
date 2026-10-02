<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LiveSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'description',
        'scheduled_at',
        'duration_minutes',
        'jitsi_room_id',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function isUpcoming(): bool
    {
        return $this->status === 'scheduled' && $this->scheduled_at->isFuture();
    }

    public function isLive(): bool
    {
        return $this->status === 'live';
    }

    public function jitsiUrl(): string
    {
        return rtrim(config('services.jitsi.server', 'https://meet.jit.si'), '/') . '/' . $this->jitsi_room_id;
    }

    protected static function booted(): void
    {
        static::creating(function ($session) {
            if (empty($session->jitsi_room_id)) {
                $session->jitsi_room_id = Str::slug($session->title) . '-' . Str::random(8);
            }
        });
    }
}