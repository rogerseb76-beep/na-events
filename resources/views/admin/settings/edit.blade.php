@extends('layouts.admin')

@section('title', 'Paramètres')

@section('content')

<x-admin.page-header
    eyebrow="ADMINISTRATION"
    title="État des inscriptions"
    subtitle="Ouvrez ou fermez les réservations publiques sans bloquer l’administration."
/>

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

<x-admin.card>

    <form
        method="POST"
        action="{{ route('admin.settings.update') }}"
    >
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label
                for="registration_state"
                class="form-label na-form-label"
            >
                État actuel
            </label>

            <select
                id="registration_state"
                name="registration_state"
                class="form-select @error('registration_state') is-invalid @enderror"
                required
            >
                <option
                    value="open"
                    @selected(
                        old(
                            'registration_state',
                            $registrationState
                        ) === 'open'
                    )
                >
                    Ouvert — réservations autorisées
                </option>

                <option
                    value="live"
                    @selected(
                        old(
                            'registration_state',
                            $registrationState
                        ) === 'live'
                    )
                >
                    Journée en cours — consultation seulement
                </option>

                <option
                    value="closed"
                    @selected(
                        old(
                            'registration_state',
                            $registrationState
                        ) === 'closed'
                    )
                >
                    Fermé — réservations indisponibles
                </option>
            </select>

            @error('registration_state')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="row g-4">

            <div class="col-12">
                <label
                    for="registration_message_open"
                    class="form-label na-form-label"
                >
                    Message lorsque les inscriptions sont ouvertes
                </label>

                <textarea
                    id="registration_message_open"
                    name="registration_message_open"
                    rows="3"
                    class="form-control @error('registration_message_open') is-invalid @enderror"
                    required
                >{{ old(
                    'registration_message_open',
                    $messages['open']
                ) }}</textarea>
            </div>

            <div class="col-12">
                <label
                    for="registration_message_live"
                    class="form-label na-form-label"
                >
                    Message pendant la journée
                </label>

                <textarea
                    id="registration_message_live"
                    name="registration_message_live"
                    rows="3"
                    class="form-control @error('registration_message_live') is-invalid @enderror"
                    required
                >{{ old(
                    'registration_message_live',
                    $messages['live']
                ) }}</textarea>
            </div>

            <div class="col-12">
                <label
                    for="registration_message_closed"
                    class="form-label na-form-label"
                >
                    Message lorsque les inscriptions sont fermées
                </label>

                <textarea
                    id="registration_message_closed"
                    name="registration_message_closed"
                    rows="3"
                    class="form-control @error('registration_message_closed') is-invalid @enderror"
                    required
                >{{ old(
                    'registration_message_closed',
                    $messages['closed']
                ) }}</textarea>
            </div>

        </div>

        <hr class="my-4">

        <div class="d-flex justify-content-end">
            <button
                type="submit"
                class="btn btn-na-primary"
            >
                Enregistrer les paramètres
            </button>
        </div>

    </form>

</x-admin.card>

@endsection
