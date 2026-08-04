<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    protected $fillable = [
        'event_session_id',
        'lastname',
        'firstname',
        'email',
        'phone',
        'club',
        'confirmed',
        'checked_in',
    ];

    protected function casts(): array
    {
        return [
            'confirmed' => 'boolean',
            'checked_in' => 'boolean',
        ];
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(EventSession::class, 'event_session_id');
    }
}