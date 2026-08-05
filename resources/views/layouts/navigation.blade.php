<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold text-warning" href="{{ route('admin.dashboard') }}">
            NORMANDIE ARCHERIE
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbar"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar">

            <ul class="navbar-nav me-auto">

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
                        Évènements
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
                        class="nav-link"
                        href="{{ route('home') }}"
                        target="_blank"
                    >
                        Site public
                    </a>
                </li>

            </ul>

            @auth

                <span class="navbar-text text-light me-3">
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

            @endauth

        </div>

    </div>
</nav>