<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Feuille d'émargement</title>
    <style>
        @page {
            margin: 24px 28px 34px;
        }

        body {
            margin: 0;
            color: #171717;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            line-height: 1.35;
        }

        .page {
            position: relative;
        }

        .page-break {
            page-break-after: always;
        }

        .header {
            width: 100%;
            margin-bottom: 14px;
            border-collapse: collapse;
        }

        .header td {
            vertical-align: middle;
        }

        .logo-cell {
            width: 120px;
        }

        .logo {
            width: 98px;
            height: auto;
        }

        .header-content {
            text-align: right;
        }

        .brand {
            margin: 0 0 3px;
            color: #B68B24;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.3px;
            text-transform: uppercase;
        }

        h1 {
            margin: 0 0 3px;
            font-size: 21px;
            line-height: 1.15;
        }

        .subtitle {
            margin: 0;
            color: #666666;
            font-size: 9px;
        }

        .gold-line {
            height: 3px;
            margin-bottom: 14px;
            background: #B68B24;
        }

        .event-box {
            margin-bottom: 14px;
            padding: 10px 12px;
            border: 1px solid #DED5BE;
            background: #F7F4EC;
        }

        .event-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .event-box td {
            padding: 2px 0;
            vertical-align: top;
        }

        .label {
            width: 105px;
            color: #666666;
            font-weight: bold;
        }

        .summary {
            margin-bottom: 10px;
            text-align: right;
            color: #555555;
            font-size: 9px;
        }

        .participants-table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        .participants-table thead {
            display: table-header-group;
        }

        .participants-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .participants-table th {
            padding: 7px 6px;
            border: 1px solid #222222;
            background: #171717;
            color: #FFFFFF;
            font-size: 9px;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .participants-table td {
            height: 31px;
            padding: 6px;
            border: 1px solid #D7D7D7;
            vertical-align: middle;
        }

        .participants-table tbody tr:nth-child(even) {
            background: #FAFAFA;
        }

        .number-column {
            width: 25px;
            text-align: center;
        }

        .name-column {
            width: 120px;
        }

        .firstname-column {
            width: 105px;
        }

        .club-column {
            width: 145px;
        }

        .signature-column {
            width: auto;
        }

        .empty-state {
            padding: 22px;
            border: 1px solid #D7D7D7;
            color: #777777;
            text-align: center;
        }

        .notes {
            margin-top: 14px;
            padding-top: 10px;
            border-top: 1px solid #DDDDDD;
        }

        .notes-line {
            height: 24px;
            border-bottom: 1px solid #CCCCCC;
        }

        .footer {
            position: fixed;
            right: 28px;
            bottom: 12px;
            left: 28px;
            color: #777777;
            font-size: 8px;
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

@php
    $club = config('na-events.club');
    $pdfConfig = config('na-events.pdf');
    $logoPath = public_path($club['logo']);
    $participantsCount = $session->participants->count();
@endphp

<div class="page">

    <table class="header">
        <tr>
            <td class="logo-cell">
                @if(is_file($logoPath))
                    <img
                        src="{{ $logoPath }}"
                        alt="{{ $club['name'] }}"
                        class="logo"
                    >
                @endif
            </td>

            <td class="header-content">
                <p class="brand">{{ $club['name'] }}</p>
                <h1>Feuille d'émargement</h1>
                <p class="subtitle">Liste officielle des participants inscrits</p>
            </td>
        </tr>
    </table>

    <div class="gold-line"></div>

    <div class="event-box">
        <table>
            <tr>
                <td class="label">Événement</td>
                <td>{{ $event->title }}</td>
            </tr>
            <tr>
                <td class="label">Date</td>
                <td>{{ $event->event_date->translatedFormat('l j F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Lieu</td>
                <td>{{ $event->location }}</td>
            </tr>
            <tr>
                <td class="label">Session</td>
                <td>
                    {{ $session->title }} -
                    {{ substr($session->start_time, 0, 5) }} à
                    {{ substr($session->end_time, 0, 5) }}
                </td>
            </tr>
            <tr>
                <td class="label">Capacité</td>
                <td>
                    {{ $participantsCount }} inscrit{{ $participantsCount > 1 ? 's' : '' }}
                    sur {{ $session->capacity }} places
                </td>
            </tr>
        </table>
    </div>

    <div class="summary">
        Impression du {{ now()->format('d/m/Y à H:i') }}
    </div>

    @if($session->participants->isEmpty())
        <div class="empty-state">
            Aucun participant inscrit pour cette session.
        </div>
    @else
        <table class="participants-table">
            <thead>
                <tr>
                    <th class="number-column">N°</th>
                    <th class="name-column">Nom</th>
                    <th class="firstname-column">Prénom</th>
                    <th class="club-column">Club</th>
                    <th class="signature-column">Signature</th>
                </tr>
            </thead>
            <tbody>
                @foreach($session->participants as $participant)
                    <tr>
                        <td class="number-column">{{ $loop->iteration }}</td>
                        <td>{{ strtoupper($participant->lastname) }}</td>
                        <td>{{ $participant->firstname }}</td>
                        <td>{{ $participant->club ?: '—' }}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="notes">
        <strong>Responsable :</strong>
        <div class="notes-line"></div>

        <strong>Observations :</strong>
        <div class="notes-line"></div>
        <div class="notes-line"></div>
    </div>

</div>

<div class="footer">
    <table class="footer-table">
        <tr>
            <td>{{ $pdfConfig['footer_text'] }}</td>
            <td>{{ $event->title }} - Session {{ substr($session->start_time, 0, 5) }}</td>
        </tr>
    </table>
</div>

</body>
</html>
