<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->withCount('sessions')
            ->orderByDesc('event_date')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEvent($request);

        $validated['slug'] = $this->makeUniqueSlug(
            $validated['title'],
            $validated['event_date']
        );

        $validated['is_active'] = $request->boolean('is_active');

        Event::create($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'L’événement a bien été créé.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $this->validateEvent($request);

        $newSlug = Str::slug(
            $validated['title'].'-'.$validated['event_date']
        );

        if ($newSlug !== $event->slug) {
            $validated['slug'] = $this->makeUniqueSlug(
                $validated['title'],
                $validated['event_date'],
                $event->id
            );
        }

        $validated['is_active'] = $request->boolean('is_active');

        $event->update($validated);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'L’événement a bien été modifié.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $hasParticipants = $event->sessions()
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

    private function validateEvent(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => ['required', 'date'],
            'location' => ['required', 'string', 'max:255'],
        ]);
    }

    private function makeUniqueSlug(
        string $title,
        string $eventDate,
        ?int $ignoredEventId = null
    ): string {
        $baseSlug = Str::slug($title.'-'.$eventDate);
        $slug = $baseSlug;
        $counter = 2;

        while (
            Event::query()
                ->when(
                    $ignoredEventId,
                    fn ($query) => $query->whereKeyNot($ignoredEventId)
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}