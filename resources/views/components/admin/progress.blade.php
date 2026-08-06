@props([
    'value' => 0,
    'height' => '10px',
    'showValue' => true,
    'color' => 'gold',
])

@php
    $value = max(0, min(100, (int) $value));

    $barClass = match ($color) {
        'success' => 'na-progress-bar bg-success',
        'danger'  => 'na-progress-bar bg-danger',
        'warning' => 'na-progress-bar bg-warning',
        default   => 'na-progress-bar na-progress-gold',
    };
@endphp

<div class="na-progress-wrapper">

    <div
        class="progress"
        style="height: {{ $height }};"
    >
        <div
            class="{{ $barClass }}"
            role="progressbar"
            style="width: {{ $value }}%;"
            aria-valuenow="{{ $value }}"
            aria-valuemin="0"
            aria-valuemax="100"
        ></div>
    </div>

    @if($showValue)
        <div class="na-progress-value">
            {{ $value }} %
        </div>
    @endif

</div>