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

    /**
     * Participants confirmés uniquement.
     *
     * Cette relation reste volontairement nommée "participants"
     * afin que les tableaux de bord, PDF et exports existants
     * continuent à compter uniquement les places réellement occupées.
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class)
            ->where(
                'registration_status',
                Participant::STATUS_CONFIRMED
            );
    }

    /**
     * Tous les dossiers, y compris attente et annulation.
     */
    public function allParticipants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function waitingParticipants(): HasMany
    {
        return $this->hasMany(Participant::class)
            ->where(
                'registration_status',
                Participant::STATUS_WAITING
            )
            ->orderBy('created_at')
            ->orderBy('id');
    }

    public function cancelledParticipants(): HasMany
    {
        return $this->hasMany(Participant::class)
            ->where(
                'registration_status',
                Participant::STATUS_CANCELLED
            );
    }

    public function getRemainingPlacesAttribute(): int
    {
        return max(
            0,
            $this->capacity - $this->participants()->count()
        );
    }

    public function getIsFullAttribute(): bool
    {
        return $this->remaining_places === 0;
    }

    public function getWaitingCountAttribute(): int
    {
        return $this->waitingParticipants()->count();
    }
}
