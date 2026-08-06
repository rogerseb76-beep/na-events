@props([
    'value',
])

{{ \App\Support\DateFormatter::time($value) }}
