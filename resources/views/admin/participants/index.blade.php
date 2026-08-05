@extends('layouts.admin')

@section('title', 'Participants')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="dashboard-kicker mb-1">ADMINISTRATION</p>
        <h1 class="h2 mb-0">Participants</h1>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark">
        Retour au tableau de bord
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">

        <div class="row g-3 align-items-end">

            <div class="col-lg-7">
                <label for="participant-search" class="form-label">
                    Rechercher un participant
                </label>

                <input
                    type="search"
                    id="participant-search"
                    class="form-control"
                    placeholder="Nom, prénom, e-mail ou club"
                >
            </div>

            <div class="col-lg-5">
                <label for="session-filter" class="form-label">
                    Filtrer par session
                </label>

                <select id="session-filter" class="form-select">
                    <option value="">Toutes les sessions</option>

                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}">
                            {{ $session->title }}
                            —
                            {{ substr($session->start_time, 0, 5) }}
                            à
                            {{ substr($session->end_time, 0, 5) }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <p class="mb-4">
            <span id="participant-count">{{ $participants->count() }}</span>
            participant(s) affiché(s)
        </p>

        @if($participants->isEmpty())

            <div class="alert alert-info mb-0">
                Aucun participant enregistré.
            </div>

        @else

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Participant</th>
                            <th>E-mail</th>
                            <th>Club</th>
                            <th>Session</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody id="participants-table-body">

                        @foreach($participants as $participant)

                            <tr
                                class="participant-row"
                                data-search="{{ strtolower(
                                    $participant->lastname . ' ' .
                                    $participant->firstname . ' ' .
                                    $participant->email . ' ' .
                                    ($participant->club ?? '')
                                ) }}"
                                data-session="{{ $participant->event_session_id }}"
                            >

                                <td>
                                    <div class="d-flex align-items-center gap-3">

                                        <div class="participant-initials">
                                            {{ strtoupper(substr($participant->firstname, 0, 1)) }}
                                            {{ strtoupper(substr($participant->lastname, 0, 1)) }}
                                        </div>

                                        <div>
                                            <strong>
                                                {{ $participant->lastname }}
                                                {{ $participant->firstname }}
                                            </strong>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    {{ $participant->email }}
                                </td>

                                <td>
                                    {{ $participant->club ?: '—' }}
                                </td>

                                <td>
                                    <span class="badge text-bg-dark">
                                        {{ substr($participant->session->start_time, 0, 5) }}
                                        –
                                        {{ substr($participant->session->end_time, 0, 5) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        <a
                                            href="{{ route('admin.participants.edit', $participant) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Modifier
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.participants.destroy', $participant) }}"
                                            onsubmit="return confirm('Supprimer cette inscription ?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                            >
                                                Supprimer
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>

            <div
                id="no-results"
                class="alert alert-info mt-3 d-none"
            >
                Aucun participant ne correspond à votre recherche.
            </div>

        @endif

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('participant-search');
    const sessionFilter = document.getElementById('session-filter');
    const rows = document.querySelectorAll('.participant-row');
    const countElement = document.getElementById('participant-count');
    const noResults = document.getElementById('no-results');

    function filterParticipants() {
        const searchValue = searchInput.value.trim().toLowerCase();
        const sessionValue = sessionFilter.value;

        let visibleCount = 0;

        rows.forEach(function (row) {
            const matchesSearch =
                searchValue === '' ||
                row.dataset.search.includes(searchValue);

            const matchesSession =
                sessionValue === '' ||
                row.dataset.session === sessionValue;

            const shouldShow = matchesSearch && matchesSession;

            row.classList.toggle('d-none', !shouldShow);

            if (shouldShow) {
                visibleCount++;
            }
        });

        countElement.textContent = visibleCount;

        if (noResults) {
            noResults.classList.toggle('d-none', visibleCount !== 0);
        }
    }

    searchInput.addEventListener('input', filterParticipants);
    sessionFilter.addEventListener('change', filterParticipants);
});
</script>

@endsection