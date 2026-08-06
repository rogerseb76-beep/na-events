<?php

namespace App\Exports;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ParticipantsExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    public function query(): Builder
    {
        return Participant::query()
            ->with([
                'session' => fn ($query) => $query->with('event'),
            ])
            ->join(
                'event_sessions',
                'participants.event_session_id',
                '=',
                'event_sessions.id'
            )
            ->orderBy('event_sessions.start_time')
            ->orderBy('participants.lastname')
            ->orderBy('participants.firstname')
            ->select('participants.*');
    }

    public function headings(): array
    {
        return [
            'Événement',
            'Date de l’événement',
            'Session',
            'Horaires',
            'Nom',
            'Prénom',
            'E-mail',
            'Téléphone',
            'Club',
            'Date d’inscription',
        ];
    }

    public function map($participant): array
    {
        $session = $participant->session;
        $event = $session?->event;

        return [
            $event?->title ?? '',
            $event?->event_date?->format('d/m/Y') ?? '',
            $session?->title ?? '',
            $session
                ? substr($session->start_time, 0, 5)
                    .' - '
                    .substr($session->end_time, 0, 5)
                : '',
            strtoupper($participant->lastname),
            $participant->firstname,
            $participant->email,
            $participant->phone ?? '',
            $participant->club ?? '',
            $participant->created_at?->format('d/m/Y H:i') ?? '',
        ];
    }
}