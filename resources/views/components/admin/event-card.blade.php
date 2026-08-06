@props([
    'event',
])

@php
    $sessionsCount = $event->sessions_count ?? $event->sessions->count();

    $totalCapacity = $event->sessions->sum('capacity');

    $totalParticipants = $event->sessions->sum(
        fn ($session) => $session->participants->count()
    );

    $remainingPlaces = max(
        0,
        $totalCapacity - $totalParticipants
    );

    $fillRate = $totalCapacity > 0
        ? round(($totalParticipants / $totalCapacity) * 100)
        : 0;

    $progressColor = match (true) {
        $fillRate >= 100 => 'danger',
        $fillRate >= 80 => 'warning',
        default => 'success',
    };
@endphp

<x-admin.card class="h-100">

    <x-slot:header>

        <div class="d-flex justify-content-between align-items-start gap-3">

            <div>

                <p class="na-eyebrow mb-2">
                    {{ $event->event_date->translatedFormat('l j F Y') }}
                </p>

                <h2 class="h4 mb-2">
                    {{ $event->title }}
                </h2>

                <p class="text-muted mb-0">
                    📍 {{ $event->location }}
                </p>

            </div>

            @if($event->is_active)

                <x-admin.badge type="success">
                    Actif
                </x-admin.badge>

            @else

                <x-admin.badge>
                    Inactif
                </x-admin.badge>

            @endif

        </div>

    </x-slot:header>

    <p class="text-muted">
        {{ \Illuminate\Support\Str::limit(
            $event->description,
            180
        ) }}
    </p>

    <div class="row g-3 text-center my-4">

        <div class="col-6 col-md-3">

            <div class="fw-bold fs-4">
                {{ $sessionsCount }}
            </div>

            <small class="text-muted">
                Session{{ $sessionsCount > 1 ? 's' : '' }}
            </small>

        </div>

        <div class="col-6 col-md-3">

            <div class="fw-bold fs-4">
                {{ $totalParticipants }}
            </div>

            <small class="text-muted">
                Inscrit{{ $totalParticipants > 1 ? 's' : '' }}
            </small>

        </div>

        <div class="col-6 col-md-3">

            <div class="fw-bold fs-4">
                {{ $totalCapacity }}
            </div>

            <small class="text-muted">
                Capacité
            </small>

        </div>

        <div class="col-6 col-md-3">

            <div class="fw-bold fs-4">
                {{ $remainingPlaces }}
            </div>

            <small class="text-muted">
                Restante{{ $remainingPlaces > 1 ? 's' : '' }}
            </small>

        </div>

    </div>

    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center mb-2">

            <span class="small fw-semibold">
                Taux de remplissage
            </span>

            <span class="small text-muted">
                {{ $totalParticipants }} / {{ $totalCapacity }}
            </span>

        </div>

        <x-admin.progress
            :value="$fillRate"
            :color="$progressColor"
        />

    </div>

    <div class="d-flex flex-wrap gap-2">

        <a
            href="{{ route(
                'admin.events.sessions.index',
                $event
            ) }}"
            class="btn btn-na-gold"
        >
            Sessions
        </a>

        <a
            href="{{ route(
                'admin.events.edit',
                $event
            ) }}"
            class="btn btn-outline-primary"
        >
            Modifier
        </a>

        <a
            href="{{ route(
                'admin.events.duplicate.form',
                $event
            ) }}"
            class="btn btn-outline-dark"
        >
            Dupliquer
        </a>

        <a
            href="{{ route(
                'admin.exports.events.workbook',
                $event
            ) }}"
            class="btn btn-outline-success"
        >
            Excel
        </a>

        <a
            href="{{ route(
                'admin.pdf.events.attendance',
                $event
            ) }}"
            class="btn btn-outline-secondary"
        >
            PDF
        </a>

        <form
            method="POST"
            action="{{ route(
                'admin.events.destroy',
                $event
            ) }}"
            onsubmit="return confirm(
                'Supprimer définitivement cet événement ?'
            );"
        >
            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="btn btn-outline-danger"
            >
                Supprimer
            </button>

        </form>

    </div>

</x-admin.card>