<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_FULL = 'full';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
        'location',
        'status',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(EventSession::class)
            ->orderBy('display_order');
    }

    public function scopePubliclyVisible(
        Builder $query
    ): Builder {
        return $query->whereIn('status', [
            self::STATUS_PUBLISHED,
            self::STATUS_FULL,
        ]);
    }

    public function isPubliclyVisible(): bool
    {
        return in_array($this->status, [
            self::STATUS_PUBLISHED,
            self::STATUS_FULL,
        ], true);
    }

    public function acceptsReservations(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function acceptsWaitingList(): bool
    {
        return in_array($this->status, [
            self::STATUS_PUBLISHED,
            self::STATUS_FULL,
        ], true);
    }

    public function isArchived(): bool
    {
        return $this->status === self::STATUS_ARCHIVED;
    }
}
