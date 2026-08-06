@extends('layouts.admin')

@section('title', 'Modifier une session')

@section('content')

<x-admin.page-header
    eyebrow="SESSIONS"
    title="Modifier la session"
    :subtitle="$event->title"
/>

<x-admin.card>
    <form
        method="POST"
        action="{{ route(
            'admin.events.sessions.update',
            [$event, $session]
        ) }}"
    >
        @method('PUT')

        @include('admin.sessions._form', [
            'submitLabel' => 'Enregistrer les modifications',
        ])
    </form>
</x-admin.card>

@endsection