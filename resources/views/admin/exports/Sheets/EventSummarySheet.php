<?php

namespace App\Exports\Sheets;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class EventSummarySheet implements
    FromArray,
    ShouldAutoSize,
    WithTitle
{
    public function __construct(
        private readonly Event $event
    ) {
    }

    public function array(): array
    {
        $sessions = $this->event->sessions;

        $totalCapacity = $sessions->sum('capacity');

        $totalParticipants = $sessions->sum(
            fn ($session) => $session->participants->count()
        );

        $remainingPlaces = max(
            0,
            $totalCapacity - $totalParticipants
        );

        $fillRate = $totalCapacity > 0
            ? round(($totalParticipants / $totalCapacity) * 100)
            : 0;

        return [
            ['NA EVENTS — RÉSUMÉ DE L’ÉVÉNEMENT'],
            [],
            ['Événement', $this->event->title],
            [
                'Date',
                $this->event->event_date?->format('d/m/Y') ?? '',
            ],
            ['Lieu', $this->event->location],
            [
                'Statut',
                $this->event->is_active ? 'Actif' : 'Inactif',
            ],
            [],
            ['Nombre de sessions', $sessions->count()],
            ['Capacité totale', $totalCapacity],
            ['Participants inscrits', $totalParticipants],
            ['Places restantes', $remainingPlaces],
            ['Taux de remplissage', $fillRate . ' %'],
            [],
            [
                'Session',
                'Horaires',
                'Capacité',
                'Inscrits',
                'Places restantes',
                'Statut',
            ],
            ...$sessions->map(function ($session): array {
                $registered = $session->participants->count();

                $remaining = max(
                    0,
                    $session->capacity - $registered
                );

                return [
                    $session->title,
                    substr($session->start_time, 0, 5)
                        . ' - '
                        . substr($session->end_time, 0, 5),
                    $session->capacity,
                    $registered,
                    $remaining,
                    $session->is_active ? 'Active' : 'Inactive',
                ];
            })->all(),
        ];
    }

    public function title(): string
    {
        return 'Résumé';
    }
}