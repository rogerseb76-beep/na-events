<?php

namespace App\Exports\Sheets;

use App\Models\EventSession;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SessionParticipantsSheet implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithTitle
{
    public function __construct(
        private readonly EventSession $session
    ) {
    }

    public function collection(): Collection
    {
        return $this->session
            ->participants()
            ->orderBy('lastname')
            ->orderBy('firstname')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'E-mail',
            'Téléphone',
            'Club',
            'Session',
            'Horaires',
            'Date d’inscription',
        ];
    }

    public function map($participant): array
    {
        return [
            strtoupper($participant->lastname),
            $participant->firstname,
            $participant->email,
            $participant->phone ?? '',
            $participant->club ?? '',
            $this->session->title,
            substr($this->session->start_time, 0, 5)
                . ' - '
                . substr($this->session->end_time, 0, 5),
            $participant->created_at?->format('d/m/Y H:i') ?? '',
        ];
    }

    public function title(): string
    {
        $title = 'S'
            . $this->session->id
            . ' '
            . substr($this->session->start_time, 0, 5);

        $title = preg_replace(
            '/[\\\\\/?*\[\]:]/',
            '-',
            $title
        );

        return mb_substr($title, 0, 31);
    }
}