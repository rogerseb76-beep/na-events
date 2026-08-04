<?php

namespace App\Http\Controllers;

use App\Models\EventSession;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create(EventSession $eventSession)
    {
        $eventSession->load('event');

        return view('reservations.create', [
            'session' => $eventSession,
        ]);
    }

   public function store(Request $request, EventSession $eventSession)
{
    $validated = $request->validate([
        'lastname'  => ['required', 'string', 'max:100'],
        'firstname' => ['required', 'string', 'max:100'],
        'email'     => ['required', 'email', 'max:255'],
        'phone'     => ['nullable', 'string', 'max:30'],
        'club'      => ['nullable', 'string', 'max:150'],
    ]);

    $eventSession->participants()->create([
        ...$validated,
        'confirmed' => true,
        'checked_in' => false,
    ]);

    return redirect()
        ->route('home')
        ->with('success', 'Votre réservation a bien été enregistrée.');
}
}