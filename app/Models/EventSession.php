<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventSession extends Model
{
    protected $fillable = [
        'event_id',
        'title',
        'start_time',
        'end_time',
        'capacity',
        'display_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
            'display_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function getRemainingPlacesAttribute(): int
    {
        return max(0, $this->capacity - $this->participants()->count());
    }

    public function getIsFullAttribute(): bool
    {
        return $this->remaining_places === 0;
    }
}