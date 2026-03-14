<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConnectionLog extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'context',
        'last_activity_at',
        'disconnected_at',
        'country',
        'pages_visited',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
        'disconnected_at' => 'datetime',
        'pages_visited' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return $this->last_activity_at && $this->last_activity_at->isAfter(now()->subMinutes(config('session.lifetime', 120)));
    }

    public function getDurationSeconds(): ?int
    {
        $end = $this->disconnected_at ?? $this->last_activity_at;
        if (!$end) {
            return null;
        }
        return (int) $this->created_at->diffInSeconds($end);
    }

    public function getDurationFormatted(): ?string
    {
        $seconds = $this->getDurationSeconds();
        if ($seconds === null) {
            return null;
        }
        $h = floor($seconds / 3600);
        $m = floor(($seconds % 3600) / 60);
        $s = $seconds % 60;
        $parts = [];
        if ($h > 0) {
            $parts[] = $h . 'h';
        }
        if ($m > 0 || $h > 0) {
            $parts[] = $m . 'min';
        }
        $parts[] = $s . 's';
        return implode(' ', $parts);
    }
}
