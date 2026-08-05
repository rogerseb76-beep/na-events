<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $event = Event::with('sessions.participants')->firstOrFail();

        $sessions = $event->sessions;

        $totalParticipants = $sessions->sum(
            fn ($session) => $session->participants->count()
        );

        $totalCapacity = $sessions->sum('capacity');

        $remainingPlaces = max(
            0,
            $totalCapacity - $totalParticipants
        );

        return view('admin.dashboard', compact(
            'event',
            'sessions',
            'totalParticipants',
            'totalCapacity',
            'remainingPlaces'
        ));
    }
}