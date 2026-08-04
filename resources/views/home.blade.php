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
                Journée de démonstration UUKHA
            </h1>

            <p class="event-date">
                Samedi 3 octobre 2026
            </p>

            <p class="lead mx-auto event-intro">
                Venez découvrir et essayer gratuitement le matériel UUKHA
                dans les installations de Normandie Archerie.
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

                <div class="col-md-4">
                    <div class="card card-session h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <p class="session-number">SESSION 1</p>
                            <h3>10h00 – 12h00</h3>
                            <p class="places">12 places restantes</p>

                            <div class="progress mb-4">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>

                            <button class="btn btn-na w-100">
                                Réserver ce créneau
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-session h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <p class="session-number">SESSION 2</p>
                            <h3>13h00 – 15h00</h3>
                            <p class="places">12 places restantes</p>

                            <div class="progress mb-4">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>

                            <button class="btn btn-na w-100">
                                Réserver ce créneau
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-session h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <p class="session-number">SESSION 3</p>
                            <h3>15h30 – 17h30</h3>
                            <p class="places">12 places restantes</p>

                            <div class="progress mb-4">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>

                            <button class="btn btn-na w-100">
                                Réserver ce créneau
                            </button>
                        </div>
                    </div>
                </div>

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