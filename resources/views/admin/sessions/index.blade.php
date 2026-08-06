@extends('layouts.admin')

@section('title', 'Sessions')

@section('content')

<x-admin.page-header
    eyebrow="ÉVÉNEMENT"
    :title="'Sessions — ' . $event->title"
    subtitle="Gérez les créneaux, capacités et disponibilités."
>
    <x-slot:actions>
        <a
            href="{{ route('admin.events.index') }}"
            class="btn btn-outline-dark"
        >
            Retour aux événements
        </a>

        <a
            href="{{ route('admin.events.sessions.create', $event) }}"
            class="btn btn-na-primary"
        >
            + Nouvelle session
        </a>

        <a
    href="{{ route('admin.pdf.events.attendance', $event) }}"
    class="btn btn-na-gold"
>
    Télécharger toutes les feuilles
</a>

    </x-slot:actions>
</x-admin.page-header>

@if($event->sessions->isEmpty())

    <div class="alert alert-info">
        Aucune session n’est encore enregistrée pour cet événement.
    </div>

@else

    <div class="row g-4">

        @foreach($event->sessions as $session)

            @php
                $registered = $session->participants_count;
                $remaining = max(0, $session->capacity - $registered);
                $rate = $session->capacity > 0
                    ? round(($registered / $session->capacity) * 100)
                    : 0;
            @endphp

            <div class="col-lg-4">
                <x-admin.card class="h-100">

                    <div class="d-flex justify-content-between gap-3 mb-3">
                        <div>
                            <p class="na-eyebrow mb-2">
                                {{ strtoupper($session->title) }}
                            </p>

                            <h2 class="h4 mb-0">
                                {{ substr($session->start_time, 0, 5) }}
                                –
                                {{ substr($session->end_time, 0, 5) }}
                            </h2>
                        </div>

                        @if(!$session->is_active)
                            <x-admin.badge>Inactive</x-admin.badge>
                        @elseif($remaining === 0)
                            <x-admin.badge type="danger">Complet</x-admin.badge>
                        @elseif($remaining <= 3)
                            <x-admin.badge type="warning">
                                Presque complet
                            </x-admin.badge>
                        @else
                            <x-admin.badge type="success">
                                Disponible
                            </x-admin.badge>
                        @endif
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <strong>{{ $registered }} / {{ $session->capacity }}</strong>
                        <span class="text-muted">{{ $remaining }} restante(s)</span>
                    </div>

                    <div class="progress na-progress mb-2">
                        <div
                            class="progress-bar"
                            style="width: {{ $rate }}%"
                        ></div>
                    </div>

                    <p class="small text-muted text-end">
                        {{ $rate }} % de remplissage
                    </p>

                    <hr>

                    <div class="d-flex flex-wrap gap-2">
                        <a
                            href="{{ route(
                                'admin.events.sessions.edit',
                                [$event, $session]
                            ) }}"
                            class="btn btn-sm btn-outline-primary"
                        >
                            Modifier
                        </a>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.events.sessions.destroy',
                                [$event, $session]
                            ) }}"
                            onsubmit="return confirm('Supprimer cette session ?');"
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

                </x-admin.card>
            </div>

        @endforeach

    </div>

@endif

@endsection