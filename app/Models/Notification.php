<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    protected $table = 'notifications';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['id', 'type', 'user_id', 'title', 'data', 'read_at'];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public static function notify(string $userId, string $type, string $title, string $message = ''): self
    {
        return static::create([
            'id' => (string) Str::uuid(),
            'type' => $type,
            'user_id' => $userId,
            'title' => $title,
            'data' => ['title' => $title, 'message' => $message ?: $title],
            'read_at' => null,
        ]);
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->whereNull('read_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
