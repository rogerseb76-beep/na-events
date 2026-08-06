@props([
    'icon' => '📊',
    'label',
    'value',
    'caption' => null,
    'color' => 'gold',
])

@php

$iconClass = match($color) {
    'success' => 'na-stat-icon na-stat-success',
    'danger' => 'na-stat-icon na-stat-danger',
    'warning' => 'na-stat-icon na-stat-warning',
    default => 'na-stat-icon',
};

@endphp

<x-admin.card class="h-100">

    <div class="d-flex align-items-center">

        <div class="{{ $iconClass }}">
            {{ $icon }}
        </div>

        <div class="ms-3">

            <div class="na-stat-label">
                {{ $label }}
            </div>

            <div class="na-stat-value">
                {{ $value }}
            </div>

            @if($caption)

                <div class="na-stat-caption">
                    {{ $caption }}
                </div>

            @endif

        </div>

    </div>

</x-admin.card>