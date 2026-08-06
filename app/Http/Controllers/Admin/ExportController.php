<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EventWorkbookExport;
use App\Exports\ParticipantsExport;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->withCount('sessions')
            ->orderByDesc('event_date')
            ->get();

        return view('admin.exports.index', compact('events'));
    }

    public function participants(): BinaryFileResponse
    {
        $filename = 'participants-'
            . now()->format('Y-m-d-His')
            . '.xlsx';

        return Excel::download(
            new ParticipantsExport(),
            $filename
        );
    }

    public function eventWorkbook(
        Event $event
    ): BinaryFileResponse {
        $filename = 'evenement-'
            . $event->slug
            . '-'
            . now()->format('Y-m-d-His')
            . '.xlsx';

        return Excel::download(
            new EventWorkbookExport($event),
            $filename
        );
    }
}