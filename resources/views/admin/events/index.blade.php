@extends('layouts.admin')

@section('title', 'Événements')

@section('content')

<x-admin.page-header
    eyebrow="ADMINISTRATION"
    title="Événements"
    subtitle="Créez, modifiez et gérez les événements de Normandie Archerie."
>
    <x-slot:actions>
        <a
            href="{{ route('admin.events.create') }}"
            class="btn btn-na-primary"
        >
            + Nouvel événement
        </a>
    </x-slot:actions>
</x-admin.page-header>

@if($events->isEmpty())

    <div class="alert alert-info">
        Aucun événement enregistré.
    </div>

@else

    <div class="row g-4">

        @foreach($events as $event)

            <div class="col-lg-6">

                <x-admin.card class="h-100">

                    <div class="d-flex justify-content-between align-items-start mb-3">

                        <div>

                            <p class="na-eyebrow mb-2">
                                {{ $event->event_date->translatedFormat('l j F Y') }}
                            </p>

                            <h2 class="h4 mb-2">
                                {{ $event->title }}
                            </h2>

                            <p class="text-muted mb-0">
                                {{ $event->location }}
                            </p>

                        </div>

                        <div>

                            @if($event->is_active)

                                <x-admin.badge type="success">
                                    Actif
                                </x-admin.badge>

                            @else

                                <x-admin.badge>
                                    Inactif
                                </x-admin.badge>

                            @endif

                        </div>

                    </div>

                    <p>
                        {{ \Illuminate\Support\Str::limit(
                            $event->description,
                            180
                        ) }}
                    </p>

                    <hr>

                    <div class="row text-center mb-4">

                        <div class="col-4">

                            <div class="fw-bold fs-4">
                                {{ $event->sessions_count }}
                            </div>

                            <small class="text-muted">
                                Session{{ $event->sessions_count > 1 ? 's' : '' }}
                            </small>

                        </div>

                        <div class="col-4">

                            <div class="fw-bold fs-4">
                                {{ $event->sessions->sum('capacity') }}
                            </div>

                            <small class="text-muted">
                                Places
                            </small>

                        </div>

                        <div class="col-4">

                            <div class="fw-bold fs-4">
                                {{ $event->sessions->sum(
                                    fn ($session) =>
                                        $session->participants->count()
                                ) }}
                            </div>

                            <small class="text-muted">
                                Inscrits
                            </small>

                        </div>

                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        <a
                            href="{{ route(
                                'admin.events.sessions.index',
                                $event
                            ) }}"
                            class="btn btn-na-gold"
                        >
                            Sessions
                        </a>

                        <a
                            href="{{ route(
                                'admin.events.edit',
                                $event
                            ) }}"
                            class="btn btn-outline-primary"
                        >
                            Modifier
                        </a>

                        <a
                            href="{{ route(
                                'admin.events.duplicate.form',
                                $event
                            ) }}"
                            class="btn btn-outline-dark"
                        >
                            Dupliquer
                        </a>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.events.destroy',
                                $event
                            ) }}"
                            onsubmit="return confirm(
                                'Supprimer définitivement cet événement ?'
                            );"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-outline-danger"
                            >
                                Supprimer
                            </button>

                        </form>

                    </div>

                </x-admin.card>

            </div>

        @endforeach

    </div>

@endif

@endsection