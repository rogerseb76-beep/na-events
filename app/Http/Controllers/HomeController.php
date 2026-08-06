<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Models\Event;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->publiclyVisible()
            ->with([
                'sessions' => fn ($query) => $query
                    ->where('is_active', true)
                    ->withCount('participants')
                    ->orderBy('display_order')
                    ->orderBy('start_time'),
            ])
            ->orderBy('event_date')
            ->get();

        $registrationState =
            AppSetting::registrationState();

        $registrationMessage =
            AppSetting::getValue(
                'registration_message_' . $registrationState,
                'Les inscriptions sont actuellement indisponibles.'
            );

        return view(
            'home',
            compact(
                'events',
                'registrationState',
                'registrationMessage'
            )
        );
    }

    public function show(Event $event): View
    {
        abort_unless(
            $event->isPubliclyVisible(),
            404
        );

        $event->load([
            'sessions' => fn ($query) => $query
                ->where('is_active', true)
                ->orderBy('display_order')
                ->orderBy('start_time'),
        ]);

        $registrationState =
            AppSetting::registrationState();

        $registrationMessage =
            AppSetting::getValue(
                'registration_message_' . $registrationState,
                'Les inscriptions sont actuellement indisponibles.'
            );

        return view(
            'events.show',
            compact(
                'event',
                'registrationState',
                'registrationMessage'
            )
        );
    }
}
