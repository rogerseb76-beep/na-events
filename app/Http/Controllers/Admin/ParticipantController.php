<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventSession;
use App\Models\Participant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ParticipantController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim(
            (string) $request->input('search')
        );

        $sessionId = $request->input('session_id');

        $registrationStatus = $request->input(
            'registration_status'
        );

        $participants = Participant::query()
            ->with('session.event')
            ->when(
                $search !== '',
                function ($query) use ($search) {
                    $query->where(
                        function ($subQuery) use ($search) {
                            $subQuery
                                ->where(
                                    'lastname',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'firstname',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'club',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )
            ->when(
                $sessionId,
                fn ($query) =>
                    $query->where(
                        'event_session_id',
                        $sessionId
                    )
            )
            ->when(
                $registrationStatus,
                fn ($query) =>
                    $query->where(
                        'registration_status',
                        $registrationStatus
                    )
            )
            ->orderByRaw(
                "CASE registration_status
                    WHEN 'confirmed' THEN 1
                    WHEN 'waiting' THEN 2
                    WHEN 'cancelled' THEN 3
                    ELSE 4
                END"
            )
            ->orderBy('lastname')
            ->orderBy('firstname')
            ->paginate(10)
            ->withQueryString();

        $sessions = EventSession::query()
            ->with('event')
            ->orderBy('start_time')
            ->get();

        return view(
            'admin.participants.index',
            compact(
                'participants',
                'sessions',
                'search',
                'sessionId',
                'registrationStatus'
            )
        );
    }

    public function edit(
        Participant $participant
    ): View {
        $sessions = EventSession::query()
            ->with('event')
            ->orderBy('start_time')
            ->get();

        return view(
            'admin.participants.edit',
            compact(
                'participant',
                'sessions'
            )
        );
    }

    public function update(
        Request $request,
        Participant $participant
    ): RedirectResponse {
        if (
            $request->input('action')
            === 'promote'
        ) {
            return $this->promote($participant);
        }

        $validated = $request->validate([
            'firstname' => [
                'required',
                'string',
                'max:255',
            ],
            'lastname' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'club' => [
                'nullable',
                'string',
                'max:255',
            ],
            'event_session_id' => [
                'required',
                'exists:event_sessions,id',
            ],
        ]);

        $participant->update($validated);

        return redirect()
            ->route('admin.participants')
            ->with(
                'success',
                'Le participant a été mis à jour.'
            );
    }

    public function destroy(
        Participant $participant
    ): RedirectResponse {
        $wasConfirmed =
            $participant->isConfirmedRegistration();

        $sessionId =
            $participant->event_session_id;

        DB::transaction(
            function () use (
                $participant,
                $wasConfirmed,
                $sessionId
            ): void {
                $participant->delete();

                if ($wasConfirmed) {
                    $this->promoteFirstWaiting(
                        $sessionId
                    );
                }
            }
        );

        return redirect()
            ->route('admin.participants')
            ->with(
                'success',
                $wasConfirmed
                    ? 'Le participant a été supprimé. La première personne en attente a été promue si une place était disponible.'
                    : 'Le participant a bien été supprimé.'
            );
    }

    private function promote(
        Participant $participant
    ): RedirectResponse {
        if (! $participant->isWaiting()) {
            return back()->with(
                'error',
                'Seule une personne en liste d’attente peut être promue.'
            );
        }

        $promoted = DB::transaction(
            function () use ($participant): bool {
                $session = EventSession::query()
                    ->lockForUpdate()
                    ->findOrFail(
                        $participant->event_session_id
                    );

                if (
                    $session->participants()->count()
                    >= $session->capacity
                ) {
                    return false;
                }

                $participant->update([
                    'registration_status' =>
                        Participant::STATUS_CONFIRMED,
                    'confirmed' => true,
                ]);

                return true;
            }
        );

        if (! $promoted) {
            return back()->with(
                'error',
                'La session est toujours complète. Aucune promotion n’a été effectuée.'
            );
        }

        return back()->with(
            'success',
            'La personne a été promue parmi les participants confirmés.'
        );
    }

    private function promoteFirstWaiting(
        int $sessionId
    ): void {
        $session = EventSession::query()
            ->lockForUpdate()
            ->find($sessionId);

        if (! $session) {
            return;
        }

        if (
            $session->participants()->count()
            >= $session->capacity
        ) {
            return;
        }

        $nextWaiting = $session
            ->waitingParticipants()
            ->first();

        if (! $nextWaiting) {
            return;
        }

        $nextWaiting->update([
            'registration_status' =>
                Participant::STATUS_CONFIRMED,
            'confirmed' => true,
        ]);
    }
}
