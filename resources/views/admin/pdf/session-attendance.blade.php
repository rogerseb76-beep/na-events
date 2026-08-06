<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <title>
        Feuille d’émargement
    </title>

    <style>
        @page {
            margin: 28px 32px;
        }

        body {
            margin: 0;
            color: #1a1a1a;
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        .header-table {
            width: 100%;
            margin-bottom: 22px;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo-cell {
            width: 120px;
        }

        .logo {
            width: 95px;
            height: auto;
        }

        .title-cell {
            text-align: right;
        }

        .brand {
            margin: 0 0 5px;
            color: #9a741f;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        h1 {
            margin: 0 0 5px;
            font-size: 23px;
        }

        .subtitle {
            margin: 0;
            color: #666666;
            font-size: 11px;
        }

        .event-box {
            margin-bottom: 22px;
            padding: 14px 16px;
            border: 1px solid #ded8c8;
            background: #f8f6f0;
        }

        .event-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .event-box td {
            padding: 3px 0;
        }

        .label {
            width: 120px;
            color: #6c6c6c;
            font-weight: bold;
        }

        .participants-table {
            width: 100%;
            border-collapse: collapse;
        }

        .participants-table th {
            padding: 9px 7px;
            border: 1px solid #cfcfcf;
            background: #1b1b1b;
            color: #ffffff;
            font-size: 10px;
            text-align: left;
        }

        .participants-table td {
            height: 34px;
            padding: 7px;
            border: 1px solid #d6d6d6;
            vertical-align: middle;
        }

        .participants-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .number-column {
            width: 28px;
            text-align: center;
        }

        .name-column {
            width: 125px;
        }

        .firstname-column {
            width: 110px;
        }

        .club-column {
            width: 150px;
        }

        .signature-column {
            width: auto;
        }

        .empty-state {
            padding: 22px;
            border: 1px solid #d6d6d6;
            color: #777777;
            text-align: center;
        }

        .footer {
            margin-top: 18px;
            color: #777777;
            font-size: 10px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td:last-child {
            text-align: right;
        }
    </style>
</head>

<body>

<table class="header-table">
    <tr>
        <td class="logo-cell">
            <img
                src="{{ public_path('images/logos/normandie-archerie.png') }}"
                alt="Normandie Archerie"
                class="logo"
            >
        </td>

        <td class="title-cell">
            <p class="brand">
                Normandie Archerie
            </p>

            <h1>
                Feuille d’émargement
            </h1>

            <p class="subtitle">
                Liste des participants inscrits
            </p>
        </td>
    </tr>
</table>

<div class="event-box">
    <table>
        <tr>
            <td class="label">
                Événement
            </td>

            <td>
                {{ $event->title }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Date
            </td>

            <td>
                {{ $event->event_date->translatedFormat('l j F Y') }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Lieu
            </td>

            <td>
                {{ $event->location }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Session
            </td>

            <td>
                {{ $session->title }}
                —
                {{ substr($session->start_time, 0, 5) }}
                à
                {{ substr($session->end_time, 0, 5) }}
            </td>
        </tr>

        <tr>
            <td class="label">
                Inscrits
            </td>

            <td>
                {{ $session->participants->count() }}
                participant{{ $session->participants->count() > 1 ? 's' : '' }}
            </td>
        </tr>
    </table>
</div>

@if($session->participants->isEmpty())

    <div class="empty-state">
        Aucun participant inscrit pour cette session.
    </div>

@else

    <table class="participants-table">
        <thead>
            <tr>
                <th class="number-column">
                    #
                </th>

                <th class="name-column">
                    Nom
                </th>

                <th class="firstname-column">
                    Prénom
                </th>

                <th class="club-column">
                    Club
                </th>

                <th class="signature-column">
                    Signature
                </th>
            </tr>
        </thead>

        <tbody>
            @foreach($session->participants as $participant)
                <tr>
                    <td class="number-column">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ strtoupper($participant->lastname) }}
                    </td>

                    <td>
                        {{ $participant->firstname }}
                    </td>

                    <td>
                        {{ $participant->club ?: '—' }}
                    </td>

                    <td>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endif

<div class="footer">
    <table class="footer-table">
        <tr>
            <td>
                NA Events — Normandie Archerie
            </td>

            <td>
                Généré le {{ now()->format('d/m/Y à H:i') }}
            </td>
        </tr>
    </table>
</div>

</body>
</html>