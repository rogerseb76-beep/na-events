@extends('layouts.app')

@section('title', 'Administration')

@section('content')

<main class="py-5">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="session-number mb-1">ADMINISTRATION</p>
                <h1 class="h2 mb-0">{{ $event->title }}</h1>
            </div>

            <a href="{{ route('home') }}" class="btn btn-outline-dark">
                Voir le site
            </a>
        </div>

        <div class="row g-4">

            @foreach($event->sessions as $session)

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">

                            <p class="session-number mb-2">
                                {{ strtoupper($session->title) }}
                            </p>

                            <h2 class="h4">
                                {{ substr($session->start_time, 0, 5) }}
                                –
                                {{ substr($session->end_time, 0, 5) }}
                            </h2>

                            <p class="mb-3">
                                {{ $session->participants->count() }}
                                inscrit(s) sur
                                {{ $session->capacity }}
                            </p>

                            <div class="progress mb-4">
                                @php
                                    $percentage = $session->capacity > 0
                                        ? ($session->participants->count() / $session->capacity) * 100
                                        : 0;
                                @endphp

                                <div
                                    class="progress-bar"
                                    style="width: {{ $percentage }}%"
                                ></div>
                            </div>

                            <hr>

                            @forelse($session->participants as $participant)

                                <div class="py-2 border-bottom">
                                    <strong>
                                        {{ $participant->firstname }}
                                        {{ $participant->lastname }}
                                    </strong>

                                    <div class="small text-muted">
                                        {{ $participant->email }}
                                    </div>

                                    @if($participant->club)
                                        <div class="small">
                                            Club : {{ $participant->club }}
                                        </div>
                                    @endif
                                </div>

                            @empty

                                <p class="text-muted mb-0">
                                    Aucun participant pour cette session.
                                </p>

                            @endforelse

                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>
</main>

@endsection