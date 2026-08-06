<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSession;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PdfController extends Controller
{
    public function sessionAttendance(
        Event $event,
        EventSession $session
    ): Response {
        $this->ensureSessionBelongsToEvent($event, $session);

        $session->load([
            'participants' => fn ($query) => $query
                ->orderBy('lastname')
                ->orderBy('firstname'),
        ]);

        $pdf = Pdf::loadView(
            'admin.pdf.session-attendance',
            compact('event', 'session')
        )->setPaper('a4', 'portrait');

        $filename = 'emargement-'
            . $event->slug
            . '-session-'
            . $session->id
            . '.pdf';

        return $pdf->download($filename);
    }

    public function eventAttendance(Event $event): Response
    {
        $event->load([
            'sessions' => fn ($query) => $query
                ->with([
                    'participants' => fn ($participantQuery) =>
                        $participantQuery
                            ->orderBy('lastname')
                            ->orderBy('firstname'),
                ])
                ->orderBy('display_order')
                ->orderBy('start_time'),
        ]);

        $pdf = Pdf::loadView(
            'admin.pdf.event-attendance',
            compact('event')
        )->setPaper('a4', 'portrait');

        $filename = 'emargement-complet-'
            . $event->slug
            . '.pdf';

        return $pdf->download($filename);
    }

    private function ensureSessionBelongsToEvent(
        Event $event,
        EventSession $session
    ): void {
        abort_unless(
            $session->event_id === $event->id,
            404
        );
    }
}