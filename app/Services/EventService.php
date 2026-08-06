<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Str;

class EventService
{
    public function create(array $data): Event
    {
        $data['slug'] = $this->makeUniqueSlug(
            $data['title'],
            $data['event_date']
        );

        return Event::create($data);
    }

    public function update(Event $event, array $data): Event
    {
        $data['slug'] = $this->makeUniqueSlug(
            $data['title'],
            $data['event_date'],
            $event->id
        );

        $event->update($data);

        return $event->refresh();
    }

    private function makeUniqueSlug(
        string $title,
        string $eventDate,
        ?int $ignoredEventId = null
    ): string {
        $baseSlug = Str::slug(
            $title . '-' . $eventDate
        );

        $slug = $baseSlug;
        $counter = 2;

        while (
            Event::query()
                ->when(
                    $ignoredEventId,
                    fn ($query) =>
                        $query->whereKeyNot($ignoredEventId)
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}