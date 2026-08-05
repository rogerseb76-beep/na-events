<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - NA Events</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">

<nav class="admin-navbar">
    <div class="container admin-navbar-inner">

        <a class="admin-brand" href="{{ route('home') }}">
            NORMANDIE ARCHERIE
        </a>

        <div class="admin-navbar-links">
            <a href="{{ route('home') }}" class="admin-navbar-link">
                Accueil
            </a>

            <a href="{{ route('admin.dashboard') }}" class="admin-navbar-link">
                Administration
            </a>
        </div>

        @auth
            <div class="admin-navbar-account">
                <span class="admin-user-name">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="admin-logout-button">
                        Déconnexion
                    </button>
                </form>
            </div>
        @endauth

    </div>
</nav>

<div class="container py-5">

    @yield('content')

</div>

</body>
</html>