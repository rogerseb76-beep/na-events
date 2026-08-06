@extends('layouts.admin')

@section('title', 'Événements')

@section('content')

<x-admin.page-header
    eyebrow="ADMINISTRATION"
    title="Événements"
    subtitle="Pilotez les événements, leurs sessions et leur remplissage."
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

            <div class="col-xl-6">

                <x-admin.event-card
                    :event="$event"
                />

            </div>

        @endforeach

    </div>

@endif

@endsection