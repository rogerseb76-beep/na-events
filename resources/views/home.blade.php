@extends('layouts.app')

@section('title', 'Inscriptions aux événements')

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

                <p class="public-overline">
                    NORMANDIE ARCHERIE
                </p>

                <h1 class="public-title">
                    Inscriptions aux événements
                </h1>

                <p class="public-description">
                    Retrouvez les événements actuellement ouverts
                    et choisissez le créneau qui vous convient.
                </p>

                @if($registrationState !== 'open')
                    <div class="alert alert-warning mt-4 mb-0">
                        {{ $registrationMessage }}
                    </div>
                @endif

            </div>
        </div>
    </section>

    <section class="public-sessions">
        <div class="container">

            <div class="public-section-heading">
                <p class="public-overline">
                    ÉVÉNEMENTS
                </p>

                <h2>
                    Événements disponibles
                </h2>
            </div>

            @if($events->isEmpty())

                <div class="alert alert-info text-center">
                    Aucun événement n’est actuellement ouvert
                    aux inscriptions.
                </div>

            @else

                <div class="row g-4">

                    @foreach($events as $event)

                        @php
                            $totalCapacity =
                                $event->sessions->sum('capacity');

                            $registered =
                                $event->sessions->sum(
                                    'participants_count'
                                );

                            $remaining = max(
                                0,
                                $totalCapacity - $registered
                            );

                            $percentage =
                                $totalCapacity > 0
                                    ? round(
                                        (
                                            $registered
                                            / $totalCapacity
                                        ) * 100
                                    )
                                    : 0;
                        @endphp

                        <div class="col-lg-6">

                            <article class="public-session-card h-100">

                                <div class="public-session-top">

                                    <p class="public-session-name">
                                        <x-date-long
                                            :value="$event->event_date"
                                            :capitalize="true"
                                        />
                                    </p>

                                    <span class="public-session-status {{ $event->status === 'full' ? 'is-full' : 'is-available' }}">
                                        {{ $event->status === 'full'
                                            ? 'Liste d’attente'
                                            : 'Ouvert'
                                        }}
                                    </span>

                                </div>

                                <h2 class="h3">
                                    {{ $event->title }}
                                </h2>

                                <p class="text-muted">
                                    {{ $event->location }}
                                </p>

                                <p>
                                    {{ \Illuminate\Support\Str::limit(
                                        $event->description,
                                        180
                                    ) }}
                                </p>

                                <p class="public-session-places">
                                    {{ $event->sessions->count() }}
                                    session{{ $event->sessions->count() > 1 ? 's' : '' }}
                                    —
                                    {{ $remaining }}
                                    place{{ $remaining > 1 ? 's' : '' }}
                                    restante{{ $remaining > 1 ? 's' : '' }}
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

                                <a
                                    href="{{ route(
                                        'public.events.show',
                                        $event
                                    ) }}"
                                    class="btn public-session-button w-100"
                                >
                                    Voir les créneaux
                                </a>

                            </article>

                        </div>

                    @endforeach

                </div>

            @endif

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
