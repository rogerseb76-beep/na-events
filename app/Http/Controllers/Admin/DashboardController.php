<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $event = Event::with([
            'sessions.participants',
        ])->first();

        return view('admin.dashboard', [
            'event' => $event,
        ]);
    }
}