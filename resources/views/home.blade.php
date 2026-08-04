@extends('layouts.app')

@section('title', 'Journée UUKHA')

@section('content')

<header class="site-header">
    <div class="container header-inner">

        <div class="logo-box">
            <img
                src="{{ asset('images/logos/normandie-archerie.png') }}"
                alt="Logo Normandie Archerie"
                class="brand-logo brand-logo-na"
            >
        </div>

        <div class="logo-box">
            <img
                src="{{ asset('images/logos/uukha.png') }}"
                alt="Logo UUKHA"
                class="brand-logo brand-logo-uukha"
            >
        </div>

    </div>
</header>

<main>

    <section class="hero">
        <div class="container text-center">

            <p class="event-label">NORMANDIE ARCHERIE PRÉSENTE</p>

            <h1 class="display-4 fw-bold">
                {{ $event->title }}
            </h1>

            <p class="event-date">
                {{ $event->event_date->translatedFormat('l j F Y') }}
            </p>

            <p class="lead mx-auto event-intro">
                {{ $event->description }}
            </p>

            <a href="#sessions" class="btn btn-na btn-lg px-4">
                Réserver gratuitement
            </a>

        </div>
    </section>

    <section id="sessions" class="py-5">
        <div class="container">

            <div class="text-center mb-5">
                <h2 class="section-title">Choisissez votre session</h2>
                <p>12 participants maximum par créneau.</p>
            </div>

            <div class="row g-4">

                @forelse($event->sessions as $session)

                    @php
                        $reserved = $session->capacity - $session->remaining_places;

                        $percentage = $session->capacity > 0
                            ? ($reserved / $session->capacity) * 100
                            : 0;
                    @endphp

                    <div class="col-md-4">
                        <div class="card card-session h-100 shadow-sm">
                            <div class="card-body text-center p-4">

                                <p class="session-number">
                                    {{ strtoupper($session->title) }}
                                </p>

                                <h3>
                                    {{ substr($session->start_time, 0, 5) }}
                                    –
                                    {{ substr($session->end_time, 0, 5) }}
                                </h3>

                                <p class="places">
                                    @if($session->is_full)
                                        Complet
                                    @else
                                        {{ $session->remaining_places }}
                                        {{ $session->remaining_places > 1 ? 'places restantes' : 'place restante' }}
                                    @endif
                                </p>

                                <div class="progress mb-4">
                                    <div
                                        class="progress-bar"
                                        role="progressbar"
                                        style="width: {{ $percentage }}%"
                                        aria-valuenow="{{ $percentage }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100"
                                    ></div>
                                </div>

                                @if($session->is_full)
                                    <button class="btn btn-secondary w-100" disabled>
                                        Complet
                                    </button>
                                @else
                                    <button class="btn btn-na w-100">
                                        Réserver ce créneau
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>

                @empty

                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            Aucun créneau disponible pour le moment.
                        </div>
                    </div>

                @endforelse

            </div>
        </div>
    </section>

    <section class="location-section py-5">
        <div class="container text-center">

            <h2 class="section-title">Informations pratiques</h2>

            <p class="mt-4">
                <strong>Normandie Archerie</strong><br>
                63 Boulevard Charles de Gaulle<br>
                Actipôle des Chartreux<br>
                76140 Le Petit-Quevilly
            </p>

            <a
                href="https://www.google.com/maps/search/?api=1&query=63+Boulevard+Charles+de+Gaulle+76140+Le+Petit-Quevilly"
                target="_blank"
                rel="noopener noreferrer"
                class="btn btn-outline-dark"
            >
                Calculer mon itinéraire
            </a>

        </div>
    </section>

</main>

<footer class="bg-dark text-white text-center py-4">
    © 2026 Normandie Archerie
</footer>

@endsection