@props([
    'type' => 'neutral',
])

@php
    $classes = match ($type) {
        'success' => 'na-badge na-badge-success',
        'warning' => 'na-badge na-badge-warning',
        'danger' => 'na-badge na-badge-danger',
        default => 'na-badge na-badge-neutral',
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>