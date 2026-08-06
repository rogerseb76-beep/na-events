<?php

namespace App\Actions\Events;

use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DuplicateEvent
{
    public function execute(Event $event): Event
    {
        return DB::transaction(function () use ($event): Event {
            $event->load([
                'sessions' => fn ($query) => $query
                    ->orderBy('display_order')
                    ->orderBy('start_time'),
            ]);

            $newDate = now()->addMonth()->format('Y-m-d');
            $newTitle = $event->title . ' - Copie';

            $copy = Event::create([
                'title' => $newTitle,
                'slug' => $this->makeUniqueSlug($newTitle, $newDate),
                'description' => $event->description,
                'event_date' => $newDate,
                'location' => $event->location,
                'is_active' => false,
            ]);

            foreach ($event->sessions as $session) {
                $copy->sessions()->create([
                    'title' => $session->title,
                    'start_time' => $session->start_time,
                    'end_time' => $session->end_time,
                    'capacity' => $session->capacity,
                    'display_order' => $session->display_order,
                    'is_active' => $session->is_active,
                ]);
            }

            return $copy;
        });
    }

    private function makeUniqueSlug(
        string $title,
        string $eventDate
    ): string {
        $baseSlug = Str::slug($title . '-' . $eventDate);
        $slug = $baseSlug;
        $counter = 2;

        while (
            Event::query()
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}