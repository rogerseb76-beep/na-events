@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

@php
    $globalRate = $totalCapacity > 0
        ? round(($totalParticipants / $totalCapacity) * 100)
        : 0;
@endphp

<section class="dashboard-hero">
    <div>
        <p class="dashboard-kicker">TABLEAU DE BORD</p>

        <h1 class="dashboard-title">
            {{ $event->title }}
        </h1>

        <p class="dashboard-date">
            {{ $event->event_date->translatedFormat('l j F Y') }}
        </p>
    </div>

    <a href="{{ route('home') }}" class="btn btn-outline-dark">
        Voir le site public
    </a>
</section>

<section class="row g-4 mb-5">

    <div class="col-md-4">
        <article class="dashboard-stat">
            <div class="dashboard-stat-icon">👥</div>

            <div>
                <span class="dashboard-stat-label">
                    Participants
                </span>

                <strong class="dashboard-stat-number">
                    {{ $totalParticipants }}
                </strong>

                <span class="dashboard-stat-caption">
                    {{ $totalParticipants > 1 ? 'inscrits' : 'inscrit' }}
                </span>
            </div>
        </article>
    </div>

    <div class="col-md-4">
        <article class="dashboard-stat">
            <div class="dashboard-stat-icon">🎯</div>

            <div>
                <span class="dashboard-stat-label">
                    Places disponibles
                </span>

                <strong class="dashboard-stat-number">
                    {{ $remainingPlaces }}
                </strong>

                <span class="dashboard-stat-caption">
                    sur {{ $totalCapacity }}
                </span>
            </div>
        </article>
    </div>

    <div class="col-md-4">
        <article class="dashboard-stat">
            <div class="dashboard-stat-icon">📊</div>

            <div>
                <span class="dashboard-stat-label">
                    Remplissage global
                </span>

                <strong class="dashboard-stat-number">
                    {{ $globalRate }} %
                </strong>

                <span class="dashboard-stat-caption">
                    {{ $sessions->count() }} sessions
                </span>
            </div>
        </article>
    </div>

</section>

<section class="dashboard-section-header">
    <div>
        <p class="dashboard-kicker">CRÉNEAUX</p>
        <h2>Suivi des sessions</h2>
    </div>
</section>

<section class="row g-4">

    @foreach($sessions as $session)

        @php
            $registered = $session->participants->count();
            $remaining = max(0, $session->capacity - $registered);

            $rate = $session->capacity > 0
                ? round(($registered / $session->capacity) * 100)
                : 0;

            $statusClass = match (true) {
                $remaining === 0 => 'session-status-full',
                $remaining <= 3 => 'session-status-warning',
                default => 'session-status-available',
            };

            $statusText = match (true) {
                $remaining === 0 => 'Complet',
                $remaining <= 3 => 'Presque complet',
                default => 'Disponible',
            };
        @endphp

        <div class="col-lg-4">
            <article class="dashboard-session">

                <header class="dashboard-session-header">
                    <div>
                        <p class="dashboard-session-name">
                            {{ strtoupper($session->title) }}
                        </p>

                        <h3>
                            {{ substr($session->start_time, 0, 5) }}
                            –
                            {{ substr($session->end_time, 0, 5) }}
                        </h3>
                    </div>

                    <span class="session-status {{ $statusClass }}">
                        {{ $statusText }}
                    </span>
                </header>

                <div class="dashboard-session-count">
                    <strong>{{ $registered }} / {{ $session->capacity }}</strong>

                    <span>
                        {{ $remaining }}
                        {{ $remaining > 1 ? 'places restantes' : 'place restante' }}
                    </span>
                </div>

                <div class="progress dashboard-progress">
                    <div
                        class="progress-bar"
                        style="width: {{ $rate }}%"
                        role="progressbar"
                        aria-valuenow="{{ $rate }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>
                </div>

                <p class="dashboard-progress-label">
                    {{ $rate }} % de remplissage
                </p>

                <div class="dashboard-participants">

                    @forelse($session->participants->take(3) as $participant)

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
                                    {{ $participant->email }}
                                </small>
                            </div>
                        </div>

                    @empty

                        <p class="dashboard-empty">
                            Aucun participant inscrit.
                        </p>

                    @endforelse

                    @if($registered > 3)
                        <p class="dashboard-more">
                            + {{ $registered - 3 }} autre(s) participant(s)
                        </p>
                    @endif

                </div>

            </article>
        </div>

    @endforeach

</section>

@endsection