@extends('layouts.admin')

@section('title', 'Événements')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="dashboard-kicker mb-1">ADMINISTRATION</p>
        <h1 class="h2 mb-0">Événements</h1>
    </div>

    <a
        href="{{ route('admin.events.create') }}"
        class="btn btn-dark"
    >
        + Nouvel événement
    </a>
</div>

@if($events->isEmpty())

    <div class="alert alert-info">
        Aucun événement enregistré.
    </div>

@else

    <div class="row g-4">

        @foreach($events as $event)

            <div class="col-lg-6">
                <article class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between gap-3 mb-3">
                            <div>
                                <p class="dashboard-kicker mb-2">
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
                                    <span class="badge text-bg-success">
                                        Actif
                                    </span>
                                @else
                                    <span class="badge text-bg-secondary">
                                        Inactif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <p>
                            {{ \Illuminate\Support\Str::limit(
                                $event->description,
                                180
                            ) }}
                        </p>

                        <p class="small text-muted">
                            {{ $event->sessions_count }}
                            {{ $event->sessions_count > 1 ? 'sessions' : 'session' }}
                        </p>

                        <hr>

                        <div class="d-flex flex-wrap gap-2">

                            <a
                                href="{{ route('admin.events.edit', $event) }}"
                                class="btn btn-sm btn-outline-primary"
                            >
                                Modifier
                            </a>

                            <form
                                method="POST"
                                action="{{ route('admin.events.destroy', $event) }}"
                                onsubmit="return confirm(
                                    'Supprimer définitivement cet événement ?'
                                );"
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

                    </div>
                </article>
            </div>

        @endforeach

    </div>

@endif

@endsection