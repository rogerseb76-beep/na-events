<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventSession;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $sessionId = $request->input('session_id');

        $participants = Participant::with('session')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('lastname', 'like', "%{$search}%")
                        ->orWhere('firstname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('club', 'like', "%{$search}%");
                });
            })
            ->when($sessionId, function ($query) use ($sessionId) {
                $query->where('event_session_id', $sessionId);
            })
            ->orderBy('lastname')
            ->orderBy('firstname')
            ->paginate(10)
            ->withQueryString();

        $sessions = EventSession::orderBy('start_time')->get();

        return view('admin.participants.index', compact(
            'participants',
            'sessions',
            'search',
            'sessionId'
        ));
    }

    public function edit(Participant $participant)
    {
        $sessions = EventSession::orderBy('start_time')->get();

        return view('admin.participants.edit', compact(
            'participant',
            'sessions'
        ));
    }

    public function update(Request $request, Participant $participant)
    {
        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'club' => ['nullable', 'string', 'max:255'],
            'event_session_id' => ['required', 'exists:event_sessions,id'],
        ]);

        $participant->update($validated);

        return redirect()
            ->route('admin.participants')
            ->with('success', 'Le participant a été mis à jour.');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        return redirect()
            ->route('admin.participants')
            ->with('success', 'Le participant a bien été supprimé.');
    }
}