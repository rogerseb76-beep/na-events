@extends('layouts.admin')

@section('title', 'Participants')

@section('content')

<x-admin.page-header
    eyebrow="ADMINISTRATION"
    title="Participants"
    subtitle="Gérez les inscriptions confirmées, les listes d’attente et les présences."
>
    <x-slot:actions>
        <a
            href="{{ route('admin.dashboard') }}"
            class="btn btn-outline-dark"
        >
            Retour au tableau de bord
        </a>
    </x-slot:actions>
</x-admin.page-header>

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

<x-admin.card class="mb-4">

    <form
        method="GET"
        action="{{ route('admin.participants') }}"
    >

        <div class="row g-3 align-items-end">

            <div class="col-lg-5">
                <label
                    for="participant-search"
                    class="form-label"
                >
                    Rechercher un participant
                </label>

                <input
                    type="search"
                    id="participant-search"
                    name="search"
                    class="form-control"
                    value="{{ $search ?? request('search') }}"
                    placeholder="Nom, prénom, e-mail ou club"
                >
            </div>

            <div class="col-lg-3">
                <label
                    for="session-filter"
                    class="form-label"
                >
                    Session
                </label>

                <select
                    id="session-filter"
                    name="session_id"
                    class="form-select"
                >
                    <option value="">
                        Toutes les sessions
                    </option>

                    @foreach($sessions as $session)
                        <option
                            value="{{ $session->id }}"
                            @selected(
                                (string) (
                                    $sessionId
                                    ?? request('session_id')
                                )
                                === (string) $session->id
                            )
                        >
                            {{ $session->event?->title }}
                            —
                            {{ $session->title }}
                            —
                            {{ substr($session->start_time, 0, 5) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-2">
                <label
                    for="registration-status-filter"
                    class="form-label"
                >
                    Inscription
                </label>

                <select
                    id="registration-status-filter"
                    name="registration_status"
                    class="form-select"
                >
                    <option value="">
                        Tous les statuts
                    </option>

                    <option
                        value="confirmed"
                        @selected(
                            ($registrationStatus ?? '')
                            === 'confirmed'
                        )
                    >
                        Confirmés
                    </option>

                    <option
                        value="waiting"
                        @selected(
                            ($registrationStatus ?? '')
                            === 'waiting'
                        )
                    >
                        Liste d’attente
                    </option>

                    <option
                        value="cancelled"
                        @selected(
                            ($registrationStatus ?? '')
                            === 'cancelled'
                        )
                    >
                        Annulés
                    </option>
                </select>
            </div>

            <div class="col-lg-2 d-grid">
                <button
                    type="submit"
                    class="btn btn-na-primary"
                >
                    Filtrer
                </button>
            </div>

        </div>

        @if(
            ($search ?? '') !== ''
            || ! empty($sessionId)
            || ! empty($registrationStatus)
        )
            <div class="mt-3">
                <a
                    href="{{ route('admin.participants') }}"
                    class="btn btn-sm btn-outline-secondary"
                >
                    Réinitialiser les filtres
                </a>
            </div>
        @endif

    </form>

</x-admin.card>

<x-admin.card>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <p class="mb-0">
            <strong>{{ $participants->total() }}</strong>
            dossier{{ $participants->total() > 1 ? 's' : '' }}
            affiché{{ $participants->total() > 1 ? 's' : '' }}
        </p>

        <p class="mb-0 text-muted small">
            Page {{ $participants->currentPage() }}
            sur {{ $participants->lastPage() }}
        </p>
    </div>

    @if($participants->isEmpty())

        <div class="alert alert-info mb-0">
            Aucun participant ne correspond aux critères sélectionnés.
        </div>

    @else

        <div class="table-responsive">
            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Session</th>
                        <th>Inscription</th>
                        <th class="text-center">Présence</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($participants as $participant)

                        <tr>

                            <td>
                                <div class="d-flex align-items-center gap-3">

                                    <div class="participant-initials">
                                        {{ strtoupper(substr($participant->firstname, 0, 1)) }}
                                        {{ strtoupper(substr($participant->lastname, 0, 1)) }}
                                    </div>

                                    <div>
                                        <strong>
                                            {{ strtoupper($participant->lastname) }}
                                            {{ $participant->firstname }}
                                        </strong>

                                        <small class="d-block text-muted">
                                            {{ $participant->email }}
                                        </small>

                                        @if($participant->phone)
                                            <small class="d-block text-muted">
                                                {{ $participant->phone }}
                                            </small>
                                        @endif

                                        @if($participant->club)
                                            <small class="d-block text-muted">
                                                {{ $participant->club }}
                                            </small>
                                        @endif
                                    </div>

                                </div>
                            </td>

                            <td>
                                @if($participant->session)
                                    <strong class="d-block">
                                        {{ $participant->session->title }}
                                    </strong>

                                    <span class="badge text-bg-dark">
                                        {{ substr($participant->session->start_time, 0, 5) }}
                                        –
                                        {{ substr($participant->session->end_time, 0, 5) }}
                                    </span>
                                @else
                                    <span class="text-muted">
                                        Session supprimée
                                    </span>
                                @endif
                            </td>

                            <td>
                                @switch($participant->registration_status)

                                    @case('confirmed')
                                        <x-admin.badge type="success">
                                            Confirmé
                                        </x-admin.badge>
                                        @break

                                    @case('waiting')
                                        <x-admin.badge type="warning">
                                            Liste d’attente
                                        </x-admin.badge>
                                        @break

                                    @case('cancelled')
                                        <x-admin.badge type="danger">
                                            Annulé
                                        </x-admin.badge>
                                        @break

                                    @default
                                        <x-admin.badge>
                                            Non défini
                                        </x-admin.badge>

                                @endswitch
                            </td>

                            <td class="text-center">
                                @if($participant->isConfirmedRegistration())

                                    <x-admin.attendance-badge
                                        :participant="$participant"
                                    />

                                    @if($participant->checked_in_at)
                                        <div class="small text-muted mt-1">
                                            Pointé à
                                            {{ $participant->checked_in_at->format('H:i') }}
                                        </div>
                                    @endif

                                @else

                                    <span class="text-muted small">
                                        Non applicable
                                    </span>

                                @endif
                            </td>

                            <td>
                                <div class="d-flex flex-column gap-2 align-items-start">

                                    @if($participant->isConfirmedRegistration())

                                        <x-admin.attendance-actions
                                            :participant="$participant"
                                        />

                                    @endif

                                    <div class="d-flex flex-wrap gap-2">

                                        @if($participant->isWaiting())

                                            <form
                                                method="POST"
                                                action="{{ route('admin.participants.update', $participant) }}"
                                            >
                                                @csrf
                                                @method('PUT')

                                                <input
                                                    type="hidden"
                                                    name="action"
                                                    value="promote"
                                                >

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-success"
                                                >
                                                    Promouvoir
                                                </button>
                                            </form>

                                        @endif

                                        <a
                                            href="{{ route('admin.participants.edit', $participant) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Modifier
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.participants.destroy', $participant) }}"
                                            onsubmit="return confirm('Supprimer définitivement ce dossier ?');"
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

                                </div>
                            </td>

                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $participants->links() }}
        </div>

    @endif

</x-admin.card>

@endsection
