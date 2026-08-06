@props([
    'start',
    'end',
    'separator' => ' – ',
])

{{ \App\Support\DateFormatter::timeRange(
    $start,
    $end,
    $separator
) }}
