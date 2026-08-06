@extends('layouts.app')

@section('title', $event->title)

@section('content')

<header class="public-header">
    <div class="container public-header-inner">

        <div class="public-logo-frame">
            <img
                src="{{ asset('images/logos/normandie-archerie.png') }}"
                alt="Normandie Archerie"
                class="public-logo public-logo-na"
            >
        </div>

        <div class="public-logo-separator"></div>

        <div class="public-logo-frame">
            <img
                src="{{ asset('images/logos/uukha.png') }}"
                alt="UUKHA"
                class="public-logo public-logo-uukha"
            >
        </div>

    </div>
</header>

<main>

    @if(session('success'))
        <div class="container pt-4">
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <section class="public-hero">
        <div class="container">

            <div class="public-hero-content">

                <p class="public-overline">
                    NORMANDIE ARCHERIE PRÉSENTE
                </p>

                <h1 class="public-title">
                    {{ $event->title }}
                </h1>

                <p class="public-date">
                    {{ $event->event_date->translatedFormat('l j F Y') }}
                </p>

                <p class="public-description">
                    {{ $event->description }}
                </p>

                <a href="#sessions" class="btn public-primary-button">
                    Réserver gratuitement
                </a>

            </div>

        </div>
    </section>

    <section id="sessions" class="public-sessions">
        <div class="container">

            <div class="public-section-heading">
                <p class="public-overline">CRÉNEAUX</p>

                <h2>
                    Choisissez votre session
                </h2>

                <p>
                    Sélectionnez le créneau qui vous convient.
                </p>
            </div>

            <div class="row g-4 justify-content-center">

                @forelse($event->sessions as $session)

                    @php
                        $reserved = $session->capacity - $session->remaining_places;

                        $percentage = $session->capacity > 0
                            ? round(($reserved / $session->capacity) * 100)
                            : 0;
                    @endphp

                    <div class="col-md-6 col-lg-4">

                        <article class="public-session-card">

                            <div class="public-session-top">

                                <p class="public-session-name">
                                    {{ strtoupper($session->title) }}
                                </p>

                                @if($session->is_full)
                                    <span class="public-session-status is-full">
                                        Complet
                                    </span>
                                @elseif($session->remaining_places <= 3)
                                    <span class="public-session-status is-warning">
                                        Presque complet
                                    </span>
                                @else
                                    <span class="public-session-status is-available">
                                        Disponible
                                    </span>
                                @endif

                            </div>

                            <h3 class="public-session-time">
                                {{ substr($session->start_time, 0, 5) }}
                                <span>—</span>
                                {{ substr($session->end_time, 0, 5) }}
                            </h3>

                            <p class="public-session-places">
                                @if($session->is_full)
                                    Plus aucune place disponible
                                @else
                                    {{ $session->remaining_places }}
                                    {{ $session->remaining_places > 1
                                        ? 'places restantes'
                                        : 'place restante'
                                    }}
                                @endif
                            </p>

                            <div class="progress public-progress">
                                <div
                                    class="progress-bar"
                                    role="progressbar"
                                    style="width: {{ $percentage }}%"
                                    aria-valuenow="{{ $percentage }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                ></div>
                            </div>

                            <p class="public-progress-caption">
                                {{ $percentage }} % rempli
                            </p>

                            @if($session->is_full)

                                <button
                                    type="button"
                                    class="btn public-disabled-button w-100"
                                    disabled
                                >
                                    Session complète
                                </button>

                            @else

                                <a
                                    href="{{ route('reservations.create', $session) }}"
                                    class="btn public-session-button w-100"
                                >
                                    Réserver ce créneau
                                </a>

                            @endif

                        </article>

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

    <section class="public-location">
        <div class="container">

            <div class="public-location-card">

                <div>
                    <p class="public-overline">INFORMATIONS PRATIQUES</p>

                    <h2>
                        Normandie Archerie
                    </h2>

                    <p class="public-address">
                        63 Boulevard Charles de Gaulle<br>
                        Actipôle des Chartreux<br>
                        76140 Le Petit-Quevilly
                    </p>
                </div>

                <a
                    href="https://www.google.com/maps/search/?api=1&query=63+Boulevard+Charles+de+Gaulle+76140+Le+Petit-Quevilly"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn public-outline-button"
                >
                    Calculer mon itinéraire
                </a>

            </div>

        </div>
    </section>

</main>

<footer class="public-footer">
    <div class="container public-footer-inner">

        <p>
            © 2026 Normandie Archerie
        </p>

        <p>
            NA Events
        </p>

    </div>
</footer>

@endsection