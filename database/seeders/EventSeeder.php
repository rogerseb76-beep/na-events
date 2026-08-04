<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::updateOrCreate(
            ['slug' => 'journee-demonstration-uukha-2026'],
            [
                'title' => 'Journée de démonstration UUKHA',
                'description' => 'Venez découvrir et essayer gratuitement le matériel UUKHA chez Normandie Archerie.',
                'event_date' => '2026-10-03',
                'location' => '63 Boulevard Charles de Gaulle, Actipôle des Chartreux, 76140 Le Petit-Quevilly',
                'is_active' => true,
            ]
        );

        $event->sessions()->delete();

        $event->sessions()->createMany([
            [
                'title' => 'Session 1',
                'start_time' => '10:00',
                'end_time' => '12:00',
                'capacity' => 12,
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Session 2',
                'start_time' => '13:00',
                'end_time' => '15:00',
                'capacity' => 12,
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Session 3',
                'start_time' => '15:30',
                'end_time' => '17:30',
                'capacity' => 12,
                'display_order' => 3,
                'is_active' => true,
            ],
        ]);
    }
}