@csrf

<div class="row g-4">

    <div class="col-12">
        <label for="title" class="form-label">
            Titre de l’événement
        </label>

        <input
            type="text"
            id="title"
            name="title"
            class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $event->title ?? '') }}"
            required
        >

        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="event_date" class="form-label">
            Date
        </label>

        <input
            type="date"
            id="event_date"
            name="event_date"
            class="form-control @error('event_date') is-invalid @enderror"
            value="{{ old(
                'event_date',
                isset($event)
                    ? $event->event_date->format('Y-m-d')
                    : ''
            ) }}"
            required
        >

        @error('event_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="location" class="form-label">
            Lieu
        </label>

        <input
            type="text"
            id="location"
            name="location"
            class="form-control @error('location') is-invalid @enderror"
            value="{{ old('location', $event->location ?? '') }}"
            required
        >

        @error('location')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-12">
        <label for="description" class="form-label">
            Description
        </label>

        <textarea
            id="description"
            name="description"
            rows="6"
            class="form-control @error('description') is-invalid @enderror"
            required
        >{{ old('description', $event->description ?? '') }}</textarea>

        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input
                type="checkbox"
                id="is_active"
                name="is_active"
                value="1"
                class="form-check-input"
                @checked(
                    old(
                        'is_active',
                        isset($event) ? $event->is_active : true
                    )
                )
            >

            <label for="is_active" class="form-check-label">
                Événement actif et visible
            </label>
        </div>
    </div>

</div>

<hr class="my-4">

<div class="d-flex justify-content-end gap-2">
    <a
        href="{{ route('admin.events.index') }}"
        class="btn btn-outline-secondary"
    >
        Annuler
    </a>

    <button type="submit" class="btn btn-dark">
        {{ $submitLabel }}
    </button>
</div>