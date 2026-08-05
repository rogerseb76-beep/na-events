@extends('layouts.guest')

@section('title', 'Connexion')

@section('content')

<div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">

        <div class="text-center mb-4">
            <p class="dashboard-kicker mb-2">
                NA EVENTS
            </p>

            <h1 class="h3 fw-bold mb-2">
                Administration
            </h1>

            <p class="text-muted mb-0">
                Connectez-vous pour gérer les événements et les participants.
            </p>
        </div>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Connexion impossible.</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            method="POST"
            action="{{ route('login') }}"
        >
            @csrf

            <div class="mb-3">
                <label
                    for="email"
                    class="form-label"
                >
                    Adresse e-mail
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                    autofocus
                >

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label
                    for="password"
                    class="form-label"
                >
                    Mot de passe
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    autocomplete="current-password"
                    required
                >

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-check mb-4">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    class="form-check-input"
                >

                <label
                    for="remember"
                    class="form-check-label"
                >
                    Rester connecté
                </label>
            </div>

            <div class="d-grid">
                <button
                    type="submit"
                    class="btn btn-dark btn-lg"
                >
                    Se connecter
                </button>
            </div>

            @if(Route::has('password.request'))
                <div class="text-center mt-4">
                    <a
                        href="{{ route('password.request') }}"
                        class="text-decoration-none"
                    >
                        Mot de passe oublié ?
                    </a>
                </div>
            @endif

        </form>

    </div>
</div>

<div class="text-center mt-4">
    <a
        href="{{ route('home') }}"
        class="text-decoration-none text-muted"
    >
        ← Retour au site public
    </a>
</div>

@endsection