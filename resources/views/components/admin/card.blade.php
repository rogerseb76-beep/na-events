@props([
    'class' => '',
])

<article {{ $attributes->merge([
    'class' => 'na-card ' . $class,
]) }}>
    @if(isset($header))
        <div class="na-card-header">
            {{ $header }}
        </div>
    @endif

    <div class="na-card-body">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="na-card-header border-top border-bottom-0">
            {{ $footer }}
        </div>
    @endif
</article>