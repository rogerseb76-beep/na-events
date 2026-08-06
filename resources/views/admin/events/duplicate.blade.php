@extends('layouts.admin')

@section('title', 'Dupliquer un événement')

@section('content')

<x-admin.page-header
    eyebrow="ÉVÉNEMENTS"
    title="Dupliquer l’événement"
    subtitle="Aucune copie ne sera créée tant que vous n’aurez pas validé ce formulaire."
/>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Merci de corriger les erreurs suivantes :</strong>

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
        action="{{ route('admin.events.duplicate.store', $event) }}"
    >
        @csrf

        <div class="row g-4">

            <div class="col-12">
                <label for="title" class="form-label na-form-label">
                    Titre de la copie
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $event->title . ' - Copie') }}"
                    required
                >

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="event_date" class="form-label na-form-label">
                    Date de la copie
                </label>

                <input
                    type="date"
                    id="event_date"
                    name="event_date"
                    class="form-control @error('event_date') is-invalid @enderror"
                    value="{{ old('event_date', now()->addMonth()->format('Y-m-d')) }}"
                    required
                >

                @error('event_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="location" class="form-label na-form-label">
                    Lieu
                </label>

                <input
                    type="text"
                    id="location"
                    name="location"
                    class="form-control @error('location') is-invalid @enderror"
                    value="{{ old('location', $event->location) }}"
                    required
                >

                @error('location')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <label for="description" class="form-label na-form-label">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    class="form-control @error('description') is-invalid @enderror"
                    required
                >{{ old('description', $event->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <div class="form-check form-switch">
                    <input
                        type="checkbox"
                        id="is_active"
                        name="is_active"
                        value="1"
                        class="form-check-input"
                        @checked(old('is_active', false))
                    >

                    <label for="is_active" class="form-check-label">
                        Activer immédiatement la copie
                    </label>
                </div>
            </div>

        </div>

        <div class="alert alert-info mt-4 mb-0">
            Les {{ $event->sessions->count() }}
            session{{ $event->sessions->count() > 1 ? 's' : '' }}
            seront également copiées. Les participants ne seront pas copiés.
        </div>

        <hr class="my-4">

        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('admin.events.index') }}"
                class="btn btn-outline-secondary"
            >
                Annuler
            </a>

            <button
                type="submit"
                class="btn btn-na-primary"
            >
                Créer la copie
            </button>

        </div>

    </form>

</x-admin.card>

@endsection