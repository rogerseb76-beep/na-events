@props([
    'value',
    'capitalize' => false,
])

{{ \App\Support\DateFormatter::long($value, $capitalize) }}
