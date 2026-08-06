@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')

<div class="dashboard-hero">

    <div>

        <p class="dashboard-kicker">
            ADMINISTRATION
        </p>

        <h1 class="dashboard-title">
            {{ $event->title }}
        </h1>

        <p class="dashboard-date">
            {{ $event->event_date->translatedFormat('l j F Y') }}
        </p>

    </div>

    <div>
        <a
            href="{{ route('admin.events.index') }}"
            class="btn btn-na-primary"
        >
            Gérer les événements
        </a>
    </div>

</div>

<div class="row g-4 mb-5">

    <div class="col-lg-3 col-md-6">

        <div class="dashboard-stat">

            <div class="dashboard-stat-icon">
                👥
            </div>

            <div>

                <span class="dashboard-stat-label">
                    Participants
                </span>

                <strong class="dashboard-stat-number">
                    {{ $totalParticipants }}
                </strong>

                <span class="dashboard-stat-caption">
                    inscrits
                </span>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="dashboard-stat">

            <div class="dashboard-stat-icon">
                🎯
            </div>

            <div>

                <span class="dashboard-stat-label">
                    Taux de remplissage
                </span>

                <strong class="dashboard-stat-number">
                    {{ $fillRate }} %
                </strong>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="dashboard-stat">

            <div class="dashboard-stat-icon">
                🪑
            </div>

            <div>

                <span class="dashboard-stat-label">
                    Places restantes
                </span>

                <strong class="dashboard-stat-number">
                    {{ $remainingPlaces }}
                </strong>

            </div>

        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="dashboard-stat">

            <div class="dashboard-stat-icon">
                ⛔
            </div>

            <div>

                <span class="dashboard-stat-label">
                    Sessions complètes
                </span>

                <strong class="dashboard-stat-number">
                    {{ $fullSessions }}
                </strong>

            </div>

        </div>

    </div>

</div>

<div class="dashboard-section-header">

    <h2>
        Sessions
    </h2>

</div>

<div class="row g-4">

@foreach($sessions as $session)

@php

$percentage = $session->capacity > 0
? round(($session->participants_count / $session->capacity) * 100)
: 0;

@endphp

<div class="col-lg-4">

<div class="dashboard-session">

<div class="dashboard-session-header">

<div>

<p class="dashboard-session-name">
{{ strtoupper($session->title) }}
</p>

<h3>
{{ substr($session->start_time,0,5) }}
—
{{ substr($session->end_time,0,5) }}
</h3>

</div>

@if($session->participants_count >= $session->capacity)

<span class="session-status session-status-full">
COMPLET
</span>

@elseif($session->participants_count >= ($session->capacity-3))

<span class="session-status session-status-warning">
BIENTÔT COMPLET
</span>

@else

<span class="session-status session-status-available">
DISPONIBLE
</span>

@endif

</div>

<div class="dashboard-session-count">

<div>

<strong>
{{ $session->participants_count }}
</strong>

<br>

<span>
participants
</span>

</div>

<div>

<strong>
{{ $session->capacity }}
</strong>

<br>

<span>
places
</span>

</div>

</div>

<div class="progress dashboard-progress">

<div
class="progress-bar"
style="width: {{ $percentage }}%"
></div>

</div>

<p class="dashboard-progress-label">

{{ $percentage }} %

</p>

<div class="dashboard-participants">

@forelse($session->participants as $participant)

<div class="dashboard-participant">

<div class="participant-initials">

{{ strtoupper(substr($participant->firstname,0,1)) }}{{ strtoupper(substr($participant->lastname,0,1)) }}

</div>

<div>

<strong>

{{ $participant->firstname }}
{{ $participant->lastname }}

</strong>

<small>

{{ $participant->club ?: 'Sans club' }}

</small>

</div>

</div>

@empty

<p class="dashboard-empty">

Aucun participant.

</p>

@endforelse

@if($session->participants_count > 5)

<p class="dashboard-more">

+ {{ $session->participants_count - 5 }}

participant(s)

</p>

@endif

</div>

</div>

</div>

@endforeach

</div>

@endsection