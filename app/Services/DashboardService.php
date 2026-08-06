<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Participant;

class DashboardService
{
    public function data(): array
    {
        $event = Event::query()
            ->with([
                'sessions' => fn ($query) => $query
                    ->with([
                        'participants' => fn ($participantQuery) =>
                            $participantQuery
                                ->latest()
                                ->limit(5),
                    ])
                    ->withCount('participants')
                    ->orderBy('display_order')
                    ->orderBy('start_time'),
            ])
            ->where('is_active', true)
            ->orderBy('event_date')
            ->firstOrFail();

        $sessions = $event->sessions;

        $totalParticipants = $sessions->sum('participants_count');
        $totalCapacity = $sessions->sum('capacity');

        $remainingPlaces = max(
            0,
            $totalCapacity - $totalParticipants
        );

        $fillRate = $totalCapacity > 0
            ? round(
                ($totalParticipants / $totalCapacity) * 100
            )
            : 0;

        $fullSessions = $sessions
            ->filter(
                fn ($session) =>
                    $session->participants_count >= $session->capacity
            )
            ->count();

        $latestParticipants = Participant::query()
            ->with('session.event')
            ->latest()
            ->limit(8)
            ->get();

        return [
            'event' => $event,
            'sessions' => $sessions,
            'totalParticipants' => $totalParticipants,
            'totalCapacity' => $totalCapacity,
            'remainingPlaces' => $remainingPlaces,
            'fillRate' => $fillRate,
            'fullSessions' => $fullSessions,
            'latestParticipants' => $latestParticipants,
        ];
    }
}