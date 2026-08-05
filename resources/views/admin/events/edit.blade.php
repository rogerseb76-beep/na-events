@extends('layouts.admin')

@section('title', 'Modifier un événement')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="dashboard-kicker mb-1">ÉVÉNEMENTS</p>
        <h1 class="h2 mb-0">Modifier l’événement</h1>
    </div>

    <a
        href="{{ route('admin.events.index') }}"
        class="btn btn-outline-dark"
    >
        Retour à la liste
    </a>
</div>

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

<div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-lg-5">

        <form
            method="POST"
            action="{{ route('admin.events.update', $event) }}"
        >
            @method('PUT')

            @include('admin.events._form', [
                'submitLabel' => 'Enregistrer les modifications',
            ])
        </form>

    </div>
</div>

@endsection