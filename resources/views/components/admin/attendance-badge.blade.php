@props([
    'participant',
])

@switch($participant->attendance_status)

    @case('present')

        <x-admin.badge type="success">
            🟢 Présent
        </x-admin.badge>

        @break

    @case('absent')

        <x-admin.badge type="danger">
            🔴 Absent
        </x-admin.badge>

        @break

    @default

        <x-admin.badge type="warning">
            🟠 En attente
        </x-admin.badge>

@endswitch