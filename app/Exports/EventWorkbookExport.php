<?php

namespace App\Exports;

use App\Exports\Sheets\EventSummarySheet;
use App\Exports\Sheets\SessionParticipantsSheet;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EventWorkbookExport implements WithMultipleSheets
{
    public function __construct(
        private readonly Event $event
    ) {
        $this->event->load([
            'sessions' => fn ($query) => $query
                ->with('participants')
                ->orderBy('display_order')
                ->orderBy('start_time'),
        ]);
    }

    public function sheets(): array
    {
        $sheets = [
            new EventSummarySheet($this->event),
        ];

        foreach ($this->event->sessions as $session) {
            $sheets[] = new SessionParticipantsSheet($session);
        }

        return $sheets;
    }
}