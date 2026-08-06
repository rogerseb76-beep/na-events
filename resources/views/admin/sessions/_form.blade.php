@csrf

<div class="row g-4">

    <div class="col-md-6">
        <label for="title" class="form-label na-form-label">
            Titre
        </label>

        <input
            type="text"
            id="title"
            name="title"
            class="form-control @error('title') is-invalid @enderror"
            value="{{ old('title', $session->title ?? '') }}"
            required
        >

        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="start_time" class="form-label na-form-label">
            Heure de début
        </label>

        <input
            type="time"
            id="start_time"
            name="start_time"
            class="form-control @error('start_time') is-invalid @enderror"
            value="{{ old(
                'start_time',
                isset($session)
                    ? substr($session->start_time, 0, 5)
                    : ''
            ) }}"
            required
        >

        @error('start_time')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-3">
        <label for="end_time" class="form-label na-form-label">
            Heure de fin
        </label>

        <input
            type="time"
            id="end_time"
            name="end_time"
            class="form-control @error('end_time') is-invalid @enderror"
            value="{{ old(
                'end_time',
                isset($session)
                    ? substr($session->end_time, 0, 5)
                    : ''
            ) }}"
            required
        >

        @error('end_time')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="capacity" class="form-label na-form-label">
            Capacité
        </label>

        <input
            type="number"
            id="capacity"
            name="capacity"
            min="1"
            max="255"
            class="form-control @error('capacity') is-invalid @enderror"
            value="{{ old('capacity', $session->capacity ?? 12) }}"
            required
        >

        @error('capacity')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="display_order" class="form-label na-form-label">
            Ordre d’affichage
        </label>

        <input
            type="number"
            id="display_order"
            name="display_order"
            min="1"
            max="255"
            class="form-control @error('display_order') is-invalid @enderror"
            value="{{ old(
                'display_order',
                $session->display_order ?? 1
            ) }}"
            required
        >

        @error('display_order')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check form-switch mb-2">

            <input
                type="checkbox"
                id="is_active"
                name="is_active"
                value="1"
                class="form-check-input @error('is_active') is-invalid @enderror"
                @checked(old(
                    'is_active',
                    isset($session)
                        ? $session->is_active
                        : true
                ))
            >

            <label
                for="is_active"
                class="form-check-label"
            >
                Session active
            </label>

            @error('is_active')
                <div class="text-danger small mt-2">
                    {{ $message }}
                </div>
            @enderror

        </div>
    </div>

</div>

<hr class="my-4">

<div class="d-flex justify-content-end gap-2">

    <a
        href="{{ route('admin.events.sessions.index', $event) }}"
        class="btn btn-outline-secondary"
    >
        Annuler
    </a>

    <button
        type="submit"
        class="btn btn-na-primary"
    >
        {{ $submitLabel }}
    </button>

</div>