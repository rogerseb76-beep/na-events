@props([
    'eyebrow' => 'ADMINISTRATION',
    'title',
    'subtitle' => null,
])

<div class="na-page-header">
    <div>
        <p class="na-eyebrow">
            {{ $eyebrow }}
        </p>

        <h1 class="na-page-title">
            {{ $title }}
        </h1>

        @if($subtitle)
            <p class="na-page-subtitle">
                {{ $subtitle }}
            </p>
        @endif
    </div>

    @if(isset($actions))
        <div class="d-flex flex-wrap gap-2">
            {{ $actions }}
        </div>
    @endif
</div>