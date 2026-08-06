@extends('layouts.admin')

@section('title', 'Nouvelle session')

@section('content')

<x-admin.page-header
    eyebrow="SESSIONS"
    title="Créer une session"
    :subtitle="$event->title"
/>

<x-admin.card>
    <form
        method="POST"
        action="{{ route('admin.events.sessions.store', $event) }}"
    >
        @include('admin.sessions._form', [
            'submitLabel' => 'Créer la session',
        ])
    </form>
</x-admin.card>

@endsection