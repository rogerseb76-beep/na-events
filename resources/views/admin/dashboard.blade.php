@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

<div class="dashboard-hero">
    <div>
        <p class="dashboard-kicker">
            ADMINISTRATION
        </p>

        <h1 class="dashboard-title">
            {{ $event->title }}
        </h1>

        <p class="dashboard-date">
            {{ $event->event_date->translatedFormat('l j F Y') }}
        </p>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <a
            href="{{ route('admin.participants') }}"
            class="btn btn-outline-dark"
        >
            Voir les participants
        </a>

        <a
            href="{{ route('admin.events.index') }}"
            class="btn btn-na-primary"
        >
            Gérer les événements
        </a>
    </div>
</div>

<div class="row g-4 mb-5">

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat">
            <div class="dashboard-stat-icon">
                👥
            </div>

            <div>
                <span class="dashboard-stat-label">
                    Participants
                </span>

                <strong class="dashboard-stat-number">
                    {{ $totalParticipants }}
                </strong>

                <span class="dashboard-stat-caption">
                    inscrit{{ $totalParticipants > 1 ? 's' : '' }}
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat">
            <div class="dashboard-stat-icon">
                🎯
            </div>

            <div>
                <span class="dashboard-stat-label">
                    Remplissage
                </span>

                <strong class="dashboard-stat-number">
                    {{ $fillRate }} %
                </strong>

                <span class="dashboard-stat-caption">
                    sur {{ $totalCapacity }} places
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat">
            <div class="dashboard-stat-icon">
                🪑
            </div>

            <div>
                <span class="dashboard-stat-label">
                    Places restantes
                </span>

                <strong class="dashboard-stat-number">
                    {{ $remainingPlaces }}
                </strong>

                <span class="dashboard-stat-caption">
                    encore disponibles
                </span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="dashboard-stat">
            <div class="dashboard-stat-icon">
                ⛔
            </div>

            <div>
                <span class="dashboard-stat-label">
                    Sessions complètes
                </span>

                <strong class="dashboard-stat-number">
                    {{ $fullSessions }}
                </strong>

                <span class="dashboard-stat-caption">
                    sur {{ $sessions->count() }}
                </span>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <div class="col-xl-8">

        <div class="dashboard-section-header">
            <div>
                <p class="dashboard-kicker mb-1">
                    CRÉNEAUX
                </p>

                <h2>
                    Suivi des sessions
                </h2>
            </div>
        </div>

        <div class="row g-4">

            @forelse($sessions as $session)

                @php
                    $percentage = $session->capacity > 0
                        ? round(
                            ($session->participants_count / $session->capacity) * 100
                        )
                        : 0;

                    $remaining = max(
                        0,
                        $session->capacity - $session->participants_count
                    );
                @endphp

                <div class="col-lg-6">

                    <article class="dashboard-session">

                        <div class="dashboard-session-header">

                            <div>
                                <p class="dashboard-session-name">
                                    {{ strtoupper($session->title) }}
                                </p>

                                <h3>
                                    {{ substr($session->start_time, 0, 5) }}
                                    —
                                    {{ substr($session->end_time, 0, 5) }}
                                </h3>
                            </div>

                            @if(!$session->is_active)

                                <span class="session-status session-status-full">
                                    INACTIVE
                                </span>

                            @elseif($session->participants_count >= $session->capacity)

                                <span class="session-status session-status-full">
                                    COMPLET
                                </span>

                            @elseif($remaining <= 3)

                                <span class="session-status session-status-warning">
                                    BIENTÔT COMPLET
                                </span>

                            @else

                                <span class="session-status session-status-available">
                                    DISPONIBLE
                                </span>

                            @endif

                        </div>

                        <div class="dashboard-session-count">

                            <div>
                                <strong>
                                    {{ $session->participants_count }}
                                </strong>

                                <br>

                                <span>
                                    participant{{ $session->participants_count > 1 ? 's' : '' }}
                                </span>
                            </div>

                            <div class="text-end">
                                <strong>
                                    {{ $remaining }}
                                </strong>

                                <br>

                                <span>
                                    place{{ $remaining > 1 ? 's' : '' }} restante{{ $remaining > 1 ? 's' : '' }}
                                </span>
                            </div>

                        </div>

                        <x-admin.progress
    :value="$percentage"
/>

                        <p class="dashboard-progress-label">
                            {{ $percentage }} % de remplissage
                        </p>

                        <div class="dashboard-participants">

                            @forelse($session->participants as $participant)

                                <div class="dashboard-participant">

                                    <div class="participant-initials">
                                        {{ strtoupper(substr($participant->firstname, 0, 1)) }}
                                        {{ strtoupper(substr($participant->lastname, 0, 1)) }}
                                    </div>

                                    <div>
                                        <strong>
                                            {{ $participant->firstname }}
                                            {{ $participant->lastname }}
                                        </strong>

                                        <small>
                                            {{ $participant->club ?: 'Sans club' }}
                                        </small>
                                    </div>

                                </div>

                            @empty

                                <p class="dashboard-empty">
                                    Aucun participant inscrit.
                                </p>

                            @endforelse

                            @if($session->participants_count > 5)

                                <p class="dashboard-more">
                                    + {{ $session->participants_count - 5 }}
                                    autre{{ $session->participants_count - 5 > 1 ? 's' : '' }}
                                    participant{{ $session->participants_count - 5 > 1 ? 's' : '' }}
                                </p>

                            @endif

                        </div>

                        <div class="mt-3">
                            <a
                                href="{{ route('admin.events.sessions.edit', [$event, $session]) }}"
                                class="btn btn-sm btn-outline-dark w-100"
                            >
                                Gérer cette session
                            </a>
                        </div>

                    </article>

                </div>

            @empty

                <div class="col-12">
                    <div class="alert alert-info">
                        Aucune session n’est enregistrée pour cet événement.
                    </div>
                </div>

            @endforelse

        </div>

    </div>

    <div class="col-xl-4">

        <div class="dashboard-section-header">
            <div>
                <p class="dashboard-kicker mb-1">
                    INSCRIPTIONS
                </p>

                <h2>
                    Derniers participants
                </h2>
            </div>
        </div>

        <article class="na-card">
            <div class="na-card-body">

                @forelse($latestParticipants as $participant)

                    <div class="dashboard-participant">

                        <div class="participant-initials">
                            {{ strtoupper(substr($participant->firstname, 0, 1)) }}
                            {{ strtoupper(substr($participant->lastname, 0, 1)) }}
                        </div>

                        <div class="flex-grow-1">

                            <strong>
                                {{ $participant->firstname }}
                                {{ $participant->lastname }}
                            </strong>

                            <small>
                                {{ $participant->email }}
                            </small>

                            @if($participant->session)
                                <small>
                                    Session :
                                    {{ substr($participant->session->start_time, 0, 5) }}
                                    —
                                    {{ substr($participant->session->end_time, 0, 5) }}
                                </small>
                            @endif

                        </div>

                    </div>

                @empty

                    <p class="dashboard-empty">
                        Aucune inscription récente.
                    </p>

                @endforelse

                <div class="mt-4 d-grid">
                    <a
                        href="{{ route('admin.participants') }}"
                        class="btn btn-na-primary"
                    >
                        Gérer tous les participants
                    </a>
                </div>

            </div>
        </article>

        <article class="na-card mt-4">
            <div class="na-card-body">

                <p class="dashboard-kicker mb-3">
                    ACCÈS RAPIDES
                </p>

                <div class="d-grid gap-2">

                    <a
                        href="{{ route('admin.events.sessions.index', $event) }}"
                        class="btn btn-outline-dark"
                    >
                        Gérer les sessions
                    </a>

                    <a
                        href="{{ route('admin.events.edit', $event) }}"
                        class="btn btn-outline-dark"
                    >
                        Modifier l’événement
                    </a>

                    <a
                        href="{{ route('home') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-outline-secondary"
                    >
                        Voir le site public
                    </a>

                </div>

            </div>
        </article>

    </div>

</div>

@endsection