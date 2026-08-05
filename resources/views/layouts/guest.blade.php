<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>@yield('title', 'Connexion') - NA Events</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-light">

<main class="min-vh-100 d-flex align-items-center py-5">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8 col-lg-5">

                <div class="text-center mb-4">

                    <a href="{{ route('home') }}">
                        <img
                            src="{{ asset('images/logos/normandie-archerie.png') }}"
                            alt="Normandie Archerie"
                            style="width: 190px; max-width: 100%; height: auto;"
                        >
                    </a>

                </div>

                @yield('content')

            </div>

        </div>

    </div>

</main>

</body>
</html>