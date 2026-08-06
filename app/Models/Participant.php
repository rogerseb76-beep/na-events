<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_WAITING = 'waiting';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'event_session_id',
        'lastname',
        'firstname',
        'email',
        'phone',
        'club',
        'registration_status',
        'confirmed',
        'attendance_status',
        'checked_in_at',
    ];

    protected function casts(): array
    {
        return [
            'confirmed' => 'boolean',
            'checked_in_at' => 'datetime',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(
            EventSession::class,
            'event_session_id'
        );
    }

    public function isConfirmedRegistration(): bool
    {
        return $this->registration_status === self::STATUS_CONFIRMED;
    }

    public function isWaiting(): bool
    {
        return $this->registration_status === self::STATUS_WAITING;
    }

    public function isCancelled(): bool
    {
        return $this->registration_status === self::STATUS_CANCELLED;
    }

    public function isPresent(): bool
    {
        return $this->attendance_status === 'present';
    }

    public function isPending(): bool
    {
        return $this->attendance_status === 'pending';
    }

    public function isAbsent(): bool
    {
        return $this->attendance_status === 'absent';
    }
}
