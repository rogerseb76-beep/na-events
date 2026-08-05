<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
{
    $event = Event::with('sessions.participants')->first();

    $totalParticipants = $event->sessions->sum(
        fn ($session) => $session->participants->count()
    );

    $totalCapacity = $event->sessions->sum('capacity');

    $remainingPlaces = $totalCapacity - $totalParticipants;

    return view('admin.dashboard', [
        'event' => $event,
        'totalParticipants' => $totalParticipants,
        'totalCapacity' => $totalCapacity,
        'remainingPlaces' => $remainingPlaces,
    ]);
}
}