@props([
    'value',
])

{{ \App\Support\DateFormatter::short($value) }}
