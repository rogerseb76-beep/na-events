<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEventSessionRequest;
use App\Models\Event;
use App\Models\EventSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventSessionController extends Controller
{
    public function index(Event $event): View
    {
        $event->load([
            'sessions' => fn ($query) => $query
                ->withCount('participants')
                ->orderBy('display_order')
                ->orderBy('start_time'),
        ]);

        return view('admin.sessions.index', compact('event'));
    }

    public function create(Event $event): View
    {
        return view('admin.sessions.create', compact('event'));
    }

    public function store(
        SaveEventSessionRequest $request,
        Event $event
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active');

        $event->sessions()->create($validated);

        return redirect()
            ->route('admin.events.sessions.index', $event)
            ->with('success', 'La session a bien été créée.');
    }

    public function edit(
        Event $event,
        EventSession $session
    ): View {
        $this->ensureSessionBelongsToEvent($event, $session);

        return view('admin.sessions.edit', compact(
            'event',
            'session'
        ));
    }

    public function update(
        SaveEventSessionRequest $request,
        Event $event,
        EventSession $session
    ): RedirectResponse {
        $this->ensureSessionBelongsToEvent($event, $session);

        $validated = $request->validated();

        $participantsCount = $session->participants()->count();
        $requestedCapacity = (int) $validated['capacity'];
        $requestedIsActive = $request->boolean('is_active');

        if ($requestedCapacity < $participantsCount) {
            return back()
                ->withInput()
                ->withErrors([
                    'capacity' =>
                        "La capacité ne peut pas être inférieure au nombre actuel de participants ({$participantsCount}).",
                ]);
        }

        if (! $requestedIsActive && $participantsCount > 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'is_active' =>
                        "Cette session contient {$participantsCount} participant(s) et ne peut pas être désactivée.",
                ]);
        }

        $validated['is_active'] = $requestedIsActive;

        $session->update($validated);

        return redirect()
            ->route('admin.events.sessions.index', $event)
            ->with('success', 'La session a bien été modifiée.');
    }

    public function destroy(
        Event $event,
        EventSession $session
    ): RedirectResponse {
        $this->ensureSessionBelongsToEvent($event, $session);

        if ($session->participants()->exists()) {
            return redirect()
                ->route('admin.events.sessions.index', $event)
                ->with(
                    'error',
                    'Cette session contient des participants et ne peut pas être supprimée.'
                );
        }

        $session->delete();

        return redirect()
            ->route('admin.events.sessions.index', $event)
            ->with('success', 'La session a bien été supprimée.');
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