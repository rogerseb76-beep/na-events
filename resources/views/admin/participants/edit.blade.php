@extends('layouts.admin')

@section('title', 'Modifier un participant')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="dashboard-kicker mb-1">ADMINISTRATION</p>

        <h1 class="h2 mb-0">
            Modifier un participant
        </h1>
    </div>

    <a
        href="{{ route('admin.participants') }}"
        class="btn btn-outline-dark"
    >
        Retour à la liste
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Merci de corriger les erreurs suivantes :</strong>

        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">

        <form
            method="POST"
            action="{{ route('admin.participants.update', $participant) }}"
        >
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label for="lastname" class="form-label">
                        Nom
                    </label>

                    <input
                        type="text"
                        id="lastname"
                        name="lastname"
                        class="form-control @error('lastname') is-invalid @enderror"
                        value="{{ old('lastname', $participant->lastname) }}"
                        required
                    >

                    @error('lastname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="firstname" class="form-label">
                        Prénom
                    </label>

                    <input
                        type="text"
                        id="firstname"
                        name="firstname"
                        class="form-control @error('firstname') is-invalid @enderror"
                        value="{{ old('firstname', $participant->firstname) }}"
                        required
                    >

                    @error('firstname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">
                        Adresse e-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $participant->email) }}"
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
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $participant->phone) }}"
                    >

                    @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="club" class="form-label">
                        Club
                    </label>

                    <input
                        type="text"
                        id="club"
                        name="club"
                        class="form-control @error('club') is-invalid @enderror"
                        value="{{ old('club', $participant->club) }}"
                    >

                    @error('club')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="event_session_id" class="form-label">
                        Session
                    </label>

                    <select
                        id="event_session_id"
                        name="event_session_id"
                        class="form-select @error('event_session_id') is-invalid @enderror"
                        required
                    >
                        @foreach($sessions as $session)
                            <option
                                value="{{ $session->id }}"
                                @selected(
                                    old(
                                        'event_session_id',
                                        $participant->event_session_id
                                    ) == $session->id
                                )
                            >
                                {{ $session->title }}
                                —
                                {{ substr($session->start_time, 0, 5) }}
                                à
                                {{ substr($session->end_time, 0, 5) }}
                            </option>
                        @endforeach
                    </select>

                    @error('event_session_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a
                    href="{{ route('admin.participants') }}"
                    class="btn btn-secondary"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Enregistrer les modifications
                </button>
            </div>

        </form>

    </div>
</div>

@endsection