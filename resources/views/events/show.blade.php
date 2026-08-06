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

    @if(session('error'))
        <div class="container pt-4">
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <section class="public-hero">
        <div class="container">
            <div class="public-hero-content">

                <a
                    href="{{ route('home') }}"
                    class="text-decoration-none d-inline-block mb-4"
                >
                    ← Tous les événements
                </a>

                <p class="public-overline">
                    NORMANDIE ARCHERIE PRÉSENTE
                </p>

                <h1 class="public-title">
                    {{ $event->title }}
                </h1>

                <p class="public-date">
                    <x-date-long
                        :value="$event->event_date"
                        :capitalize="true"
                    />
                </p>

                <p class="public-description">
                    {{ $event->description }}
                </p>

                @if(
                    $registrationState !== 'open'
                    || ! $event->acceptsWaitingList()
                )
                    <div class="alert alert-warning mt-4 mb-0">
                        {{ $registrationState !== 'open'
                            ? $registrationMessage
                            : 'Les inscriptions sont closes pour cet événement.'
                        }}
                    </div>
                @endif

            </div>
        </div>
    </section>

    <section class="public-sessions">
        <div class="container">

            <div class="public-section-heading">
                <p class="public-overline">
                    CRÉNEAUX
                </p>

                <h2>
                    Choisissez votre session
                </h2>
            </div>

            <div class="row g-4 justify-content-center">

                @forelse($event->sessions as $session)

                    @php
                        $reserved =
                            $session->capacity
                            - $session->remaining_places;

                        $percentage =
                            $session->capacity > 0
                                ? round(
                                    (
                                        $reserved
                                        / $session->capacity
                                    ) * 100
                                )
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
                                <x-time-range
                                    :start="$session->start_time"
                                    :end="$session->end_time"
                                />
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

                            @if(
                                $registrationState !== 'open'
                                || ! $event->acceptsWaitingList()
                            )

                                <button
                                    type="button"
                                    class="btn public-disabled-button w-100"
                                    disabled
                                >
                                    Réservations fermées
                                </button>

                            @elseif(
                                $session->is_full
                                || $event->status === 'full'
                            )

                                <a
                                    href="{{ route(
                                        'reservations.create',
                                        $session
                                    ) }}"
                                    class="btn public-session-button w-100"
                                >
                                    Rejoindre la liste d’attente
                                </a>

                            @else

                                <a
                                    href="{{ route(
                                        'reservations.create',
                                        $session
                                    ) }}"
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
                            Aucun créneau disponible pour cet événement.
                        </div>
                    </div>

                @endforelse

            </div>

        </div>
    </section>

</main>

<footer class="public-footer">
    <div class="container public-footer-inner">
        <p>
            © {{ now()->year }} Normandie Archerie
        </p>

        <p>
            NA Events
        </p>
    </div>
</footer>

@endsection
