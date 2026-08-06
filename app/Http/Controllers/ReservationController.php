<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\EventSession;
use App\Models\Participant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function create(
        EventSession $eventSession
    ): View|RedirectResponse {
        $eventSession->load('event');

        if (
            ! AppSetting::registrationsAreOpen()
            || ! $eventSession->event?->acceptsWaitingList()
        ) {
            return redirect()
                ->route('home')
                ->with(
                    'error',
                    'Les inscriptions ne sont pas ouvertes pour cet événement.'
                );
        }

        abort_unless(
            $eventSession->is_active,
            404
        );

        return view('reservations.create', [
            'session' => $eventSession,
        ]);
    }

    public function store(
        Request $request,
        EventSession $eventSession
    ): RedirectResponse {
        $eventSession->load('event');

        if (
            ! AppSetting::registrationsAreOpen()
            || ! $eventSession->event?->acceptsWaitingList()
        ) {
            return redirect()
                ->route('home')
                ->with(
                    'error',
                    'Les inscriptions ne sont pas ouvertes pour cet événement.'
                );
        }

        $validated = $request->validate([
            'lastname' => ['required', 'string', 'max:100'],
            'firstname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'club' => ['nullable', 'string', 'max:150'],
        ]);

        $result = DB::transaction(
            function () use (
                $eventSession,
                $validated
            ): array {
                $lockedSession = EventSession::query()
                    ->lockForUpdate()
                    ->findOrFail($eventSession->id);

                $alreadyRegistered = $lockedSession
                    ->allParticipants()
                    ->where('email', $validated['email'])
                    ->where(
                        'registration_status',
                        '!=',
                        Participant::STATUS_CANCELLED
                    )
                    ->exists();

                if ($alreadyRegistered) {
                    return [
                        'duplicate' => true,
                        'status' => null,
                    ];
                }

                $confirmedCount = $lockedSession
                    ->participants()
                    ->count();

                $status = $confirmedCount < $lockedSession->capacity
                    ? Participant::STATUS_CONFIRMED
                    : Participant::STATUS_WAITING;

                Participant::query()->create([
                    ...$validated,
                    'event_session_id' => $lockedSession->id,
                    'registration_status' => $status,
                    'confirmed' =>
                        $status === Participant::STATUS_CONFIRMED,
                    'attendance_status' => 'pending',
                    'checked_in_at' => null,
                ]);

                return [
                    'duplicate' => false,
                    'status' => $status,
                ];
            }
        );

        if ($result['duplicate']) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' =>
                        'Cette adresse e-mail est déjà inscrite ou en liste d’attente pour cette session.',
                ]);
        }

        return redirect()
            ->route('public.events.show', $eventSession->event)
            ->with(
                'success',
                $result['status'] === Participant::STATUS_WAITING
                    ? 'La session est complète. Votre demande a bien été ajoutée à la liste d’attente.'
                    : 'Votre réservation a bien été enregistrée.'
            );
    }
}
