@extends('layouts.app')

@section('title', 'Réserver une session')

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

<main class="py-5">
    <div class="container">

        <div class="mx-auto" style="max-width: 760px;">

            <a href="{{ route('home') }}" class="text-decoration-none">
                ← Retour aux créneaux
            </a>

            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body p-4 p-md-5">

                    <p class="session-number mb-2">
                        {{ strtoupper($session->title) }}
                    </p>

                    <h1 class="h2 mb-3">
                        Réserver votre session
                    </h1>

                    <p class="mb-4">
                        {{ substr($session->start_time, 0, 5) }}
                        –
                        {{ substr($session->end_time, 0, 5) }}
                    </p>

                    <form
                        method="POST"
                        action="{{ route('reservations.store', $session) }}"
                    >
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="lastname" class="form-label">
                                    Nom *
                                </label>

                                <input
                                    type="text"
                                    id="lastname"
                                    name="lastname"
                                    class="form-control"
                                    value="{{ old('lastname') }}"
                                    required
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="firstname" class="form-label">
                                    Prénom *
                                </label>

                                <input
                                    type="text"
                                    id="firstname"
                                    name="firstname"
                                    class="form-control"
                                    value="{{ old('firstname') }}"
                                    required
                                >
                            </div>

                            <div class="col-12">
    <label for="email" class="form-label">
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
                                <label for="phone" class="form-label">
                                    Téléphone
                                </label>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old('phone') }}"
                                >
                            </div>

                            <div class="col-md-6">
                                <label for="club" class="form-label">
                                    Club
                                </label>

                                <input
                                    type="text"
                                    id="club"
                                    name="club"
                                    class="form-control"
                                    value="{{ old('club') }}"
                                >
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-na btn-lg w-100">
                                    Confirmer ma réservation
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