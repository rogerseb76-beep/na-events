<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        @yield('title', 'Administration') - NA Events
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link
        rel="stylesheet"
        href="{{ asset('css/admin-theme.css') }}"
    >
</head>

<body>

@php
    $registrationState =
        \App\Models\AppSetting::registrationState();

    $registrationBadge = match ($registrationState) {
        'open' => [
            'class' => 'text-bg-success',
            'label' => 'Public ouvert',
        ],
        'live' => [
            'class' => 'text-bg-warning',
            'label' => 'Journée en cours',
        ],
        default => [
            'class' => 'text-bg-danger',
            'label' => 'Inscriptions fermées',
        ],
    };
@endphp

<nav class="navbar navbar-expand-lg navbar-dark na-navbar">
    <div class="container">

        <a
            class="navbar-brand"
            href="{{ route('admin.dashboard') }}"
        >
            NORMANDIE ARCHERIE
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#adminNavbar"
            aria-controls="adminNavbar"
            aria-expanded="false"
            aria-label="Afficher le menu"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div
            class="collapse navbar-collapse"
            id="adminNavbar"
        >
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}"
                    >
                        Tableau de bord
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}"
                        href="{{ route('admin.events.index') }}"
                    >
                        Événements
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.participants*') ? 'active' : '' }}"
                        href="{{ route('admin.participants') }}"
                    >
                        Participants
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.exports.*') ? 'active' : '' }}"
                        href="{{ route('admin.exports.index') }}"
                    >
                        Exports
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                        href="{{ route('admin.settings.edit') }}"
                    >
                        Paramètres
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="{{ route('home') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Site public
                    </a>
                </li>

            </ul>

            @auth
                <div class="d-flex flex-wrap align-items-center gap-3">

                    <span class="badge {{ $registrationBadge['class'] }}">
                        {{ $registrationBadge['label'] }}
                    </span>

                    <span class="navbar-text text-light">
                        {{ auth()->user()->name }}
                    </span>

                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-outline-warning btn-sm"
                        >
                            Déconnexion
                        </button>
                    </form>

                </div>
            @endauth
        </div>

    </div>
</nav>

<main class="container py-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

</main>

</body>
</html>
