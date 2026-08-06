@extends('layouts.app')

@section('title', 'Réserver une session')

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

<main class="py-5">
    <div class="container">

        <div class="mx-auto" style="max-width: 760px;">

            <a
                href="{{ route('home') }}"
                class="text-decoration-none"
            >
                ← Retour aux créneaux
            </a>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body p-4 p-md-5">

                    <p class="public-overline mb-2">
                        {{ strtoupper($session->title) }}
                    </p>

                    <h1 class="h2 mb-3">
                        {{ $session->is_full
                            ? 'Rejoindre la liste d’attente'
                            : 'Réserver votre session'
                        }}
                    </h1>

                    <p class="mb-2">
                        {{ substr($session->start_time, 0, 5) }}
                        –
                        {{ substr($session->end_time, 0, 5) }}
                    </p>

                    <p class="text-muted mb-4">
                        @if($session->is_full)
                            Cette session est complète. Votre demande sera enregistrée sur la liste d’attente. Nous vous contacterons si une place se libère.
                        @else
                            Il reste
                            {{ $session->remaining_places }}
                            {{ $session->remaining_places > 1
                                ? 'places disponibles'
                                : 'place disponible'
                            }}.
                        @endif
                    </p>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>
                                Merci de corriger les erreurs suivantes :
                            </strong>

                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('reservations.store', $session) }}"
                    >
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label
                                    for="lastname"
                                    class="form-label"
                                >
                                    Nom *
                                </label>

                                <input
                                    type="text"
                                    id="lastname"
                                    name="lastname"
                                    class="form-control @error('lastname') is-invalid @enderror"
                                    value="{{ old('lastname') }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6">
                                <label
                                    for="firstname"
                                    class="form-label"
                                >
                                    Prénom *
                                </label>

                                <input
                                    type="text"
                                    id="firstname"
                                    name="firstname"
                                    class="form-control @error('firstname') is-invalid @enderror"
                                    value="{{ old('firstname') }}"
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <label
                                    for="email"
                                    class="form-label"
                                >
                                    Adresse e-mail *
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    required
                                >

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label
                                    for="phone"
                                    class="form-label"
                                >
                                    Téléphone
                                </label>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
                                >
                            </div>

                            <div class="col-md-6">
                                <label
                                    for="club"
                                    class="form-label"
                                >
                                    Club
                                </label>

                                <input
                                    type="text"
                                    id="club"
                                    name="club"
                                    class="form-control @error('club') is-invalid @enderror"
                                    value="{{ old('club') }}"
                                >
                            </div>

                            <div class="col-12 mt-4">
                                <button
                                    type="submit"
                                    class="btn public-primary-button btn-lg w-100"
                                >
                                    {{ $session->is_full
                                        ? 'M’inscrire sur la liste d’attente'
                                        : 'Confirmer ma réservation'
                                    }}
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</main>

@endsection
