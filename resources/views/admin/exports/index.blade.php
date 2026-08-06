@extends('layouts.admin')

@section('title', 'Exports')

@section('content')

<x-admin.page-header
    eyebrow="ADMINISTRATION"
    title="Exports"
    subtitle="Téléchargez les données des événements et des participants."
/>

<div class="row g-4 mb-5">

    <div class="col-lg-6">

        <x-admin.card class="h-100">

            <div class="d-flex align-items-start gap-3 mb-4">

                <div class="na-stat-icon">
                    📗
                </div>

                <div>
                    <p class="na-eyebrow mb-2">
                        EXCEL GLOBAL
                    </p>

                    <h2 class="h4 mb-2">
                        Tous les participants
                    </h2>

                    <p class="text-muted mb-0">
                        Téléchargez la liste complète des participants
                        de tous les événements.
                    </p>
                </div>

            </div>

            <div class="mt-4">
                <a
                    href="{{ route('admin.exports.participants') }}"
                    class="btn btn-na-primary"
                >
                    Télécharger tous les participants
                </a>
            </div>

        </x-admin.card>

    </div>

    <div class="col-lg-6">

        <x-admin.card class="h-100">

            <div class="d-flex align-items-start gap-3 mb-4">

                <div class="na-stat-icon">
                    📄
                </div>

                <div>
                    <p class="na-eyebrow mb-2">
                        PROCHAINEMENT
                    </p>

                    <h2 class="h4 mb-2">
                        Feuilles d’émargement PDF
                    </h2>

                    <p class="text-muted mb-0">
                        Générez des feuilles imprimables pour chaque session.
                    </p>
                </div>

            </div>

            <button
                type="button"
                class="btn btn-outline-secondary"
                disabled
            >
                Bientôt disponible
            </button>

        </x-admin.card>

    </div>

</div>

<div class="mb-4">
    <p class="na-eyebrow mb-1">
        CLASSEURS PAR ÉVÉNEMENT
    </p>

    <h2 class="h3 mb-2">
        Une feuille Excel par session
    </h2>

    <p class="text-muted">
        Chaque classeur contient un résumé général et une feuille
        distincte pour chaque créneau.
    </p>
</div>

@if($events->isEmpty())

    <div class="alert alert-info">
        Aucun événement n’est disponible.
    </div>

@else

    <div class="row g-4">

        @foreach($events as $event)

            <div class="col-lg-6">

                <x-admin.card class="h-100">

                    <div class="d-flex justify-content-between gap-3 mb-3">

                        <div>
                            <p class="na-eyebrow mb-2">
                                {{ $event->event_date->translatedFormat('l j F Y') }}
                            </p>

                            <h3 class="h4 mb-2">
                                {{ $event->title }}
                            </h3>

                            <p class="text-muted mb-0">
                                {{ $event->location }}
                            </p>
                        </div>

                        <x-admin.badge
                            :type="$event->is_active ? 'success' : 'neutral'"
                        >
                            {{ $event->is_active ? 'Actif' : 'Inactif' }}
                        </x-admin.badge>

                    </div>

                    <p class="small text-muted">
                        {{ $event->sessions_count }}
                        {{ $event->sessions_count > 1
                            ? 'sessions'
                            : 'session'
                        }}
                    </p>

                    <hr>

                    <a
                        href="{{ route(
                            'admin.exports.events.workbook',
                            $event
                        ) }}"
                        class="btn btn-na-gold"
                    >
                        Télécharger le classeur complet
                    </a>

                </x-admin.card>

            </div>

        @endforeach

    </div>

@endif

@endsection