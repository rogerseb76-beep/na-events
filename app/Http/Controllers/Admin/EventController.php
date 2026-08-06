<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEventRequest;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->with([
                'sessions' => fn ($query) => $query
                    ->with('participants')
                    ->orderBy('display_order')
                    ->orderBy('start_time'),
            ])
            ->withCount('sessions')
            ->orderByDesc('event_date')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function store(
        SaveEventRequest $request,
        EventService $eventService
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active');

        $eventService->create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'L’événement a bien été créé.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(
        SaveEventRequest $request,
        Event $event,
        EventService $eventService
    ): RedirectResponse {
        $validated = $request->validated();

        $hasParticipants = $event
            ->sessions()
            ->whereHas('participants')
            ->exists();

        $newDate = $validated['event_date'];
        $currentDate = $event->event_date->format('Y-m-d');

        if ($hasParticipants && $newDate !== $currentDate) {
            return back()
                ->withInput()
                ->withErrors([
                    'event_date' =>
                        'La date d’un événement contenant déjà des participants ne peut pas être modifiée.',
                ]);
        }

        $validated['is_active'] = $request->boolean('is_active');

        $eventService->update($event, $validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'L’événement a bien été modifié.');
    }

    public function duplicateForm(Event $event): View
    {
        $event->load([
            'sessions' => fn ($query) => $query
                ->orderBy('display_order')
                ->orderBy('start_time'),
        ]);

        return view('admin.events.duplicate', compact('event'));
    }

    public function duplicateStore(
        SaveEventRequest $request,
        Event $event,
        EventService $eventService
    ): RedirectResponse {
        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active');

        $copy = $eventService->duplicate(
            $event,
            $validated
        );

        return redirect()
            ->route('admin.events.edit', $copy)
            ->with(
                'success',
                'L’événement et ses sessions ont été dupliqués.'
            );
    }

    public function destroy(Event $event): RedirectResponse
    {
        if ($event->is_active) {
            return redirect()
                ->route('admin.events.index')
                ->with(
                    'error',
                    'Un événement actif ne peut pas être supprimé. Désactivez-le d’abord.'
                );
        }

        $hasParticipants = $event
            ->sessions()
            ->whereHas('participants')
            ->exists();

        if ($hasParticipants) {
            return redirect()
                ->route('admin.events.index')
                ->with(
                    'error',
                    'Cet événement contient des participants et ne peut pas être supprimé.'
                );
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'L’événement a bien été supprimé.');
    }
}