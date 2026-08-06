<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventService
{
    public function create(array $data): Event
    {
        $data = $this->normalizeStatus($data);

        $data['slug'] = $this->makeUniqueSlug(
            $data['title'],
            $data['event_date']
        );

        return Event::create($data);
    }

    public function update(
        Event $event,
        array $data
    ): Event {
        $data = $this->normalizeStatus($data);

        $data['slug'] = $this->makeUniqueSlug(
            $data['title'],
            $data['event_date'],
            $event->id
        );

        $event->update($data);

        return $event->refresh();
    }

    public function duplicate(
        Event $event,
        array $data
    ): Event {
        return DB::transaction(
            function () use ($event, $data): Event {
                $event->load([
                    'sessions' => fn ($query) => $query
                        ->orderBy('display_order')
                        ->orderBy('start_time'),
                ]);

                $data = $this->normalizeStatus($data);

                $data['slug'] = $this->makeUniqueSlug(
                    $data['title'],
                    $data['event_date']
                );

                $copy = Event::create($data);

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
            }
        );
    }

    private function normalizeStatus(
        array $data
    ): array {
        $status = $data['status']
            ?? (
                ! empty($data['is_active'])
                    ? Event::STATUS_PUBLISHED
                    : Event::STATUS_DRAFT
            );

        $data['status'] = $status;

        $data['is_active'] = in_array(
            $status,
            [
                Event::STATUS_PUBLISHED,
                Event::STATUS_FULL,
            ],
            true
        );

        return $data;
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
