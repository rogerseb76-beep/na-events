@props([
    'event',
    'session',
])

@php

    $percentage = $session->capacity > 0
        ? round(($session->participants_count / $session->capacity) * 100)
        : 0;

    $remaining = max(
        0,
        $session->capacity - $session->participants_count
    );

@endphp

<x-admin.card>

    <x-slot:header>

        <div class="d-flex justify-content-between align-items-start">

            <div>

                <p class="dashboard-session-name mb-1">
                    {{ strtoupper($session->title) }}
                </p>

                <h3 class="h5 mb-0">
                    {{ substr($session->start_time,0,5) }}
                    —
                    {{ substr($session->end_time,0,5) }}
                </h3>

            </div>

            @if(!$session->is_active)

                <x-admin.badge>
                    Inactive
                </x-admin.badge>

            @elseif($session->participants_count >= $session->capacity)

                <x-admin.badge type="danger">
                    Complet
                </x-admin.badge>

            @elseif($remaining <= 3)

                <x-admin.badge type="warning">
                    Bientôt complet
                </x-admin.badge>

            @else

                <x-admin.badge type="success">
                    Disponible
                </x-admin.badge>

            @endif

        </div>

    </x-slot:header>

    <div class="row mb-3">

        <div class="col-6">

            <strong class="fs-3">

                {{ $session->participants_count }}

            </strong>

            <br>

            <small class="text-muted">

                participant{{ $session->participants_count > 1 ? 's' : '' }}

            </small>

        </div>

        <div class="col-6 text-end">

            <strong class="fs-3">

                {{ $remaining }}

            </strong>

            <br>

            <small class="text-muted">

                place{{ $remaining > 1 ? 's' : '' }}

            </small>

        </div>

    </div>

    <x-admin.progress
        :value="$percentage"
    />

    <div class="mt-4">

        <a
            href="{{ route(
                'admin.events.sessions.edit',
                [$event, $session]
            ) }}"
            class="btn btn-outline-dark w-100"
        >
            Gérer la session
        </a>

    </div>

</x-admin.card>