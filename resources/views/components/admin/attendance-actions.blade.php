@props([
    'participant',
])

<div class="btn-group" role="group">

    <form
        method="POST"
        action="{{ route('admin.participants.present', $participant) }}"
    >
        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="btn btn-sm btn-outline-success"
            title="Présent"
        >
            ✓
        </button>

    </form>

    <form
        method="POST"
        action="{{ route('admin.participants.pending', $participant) }}"
    >
        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="btn btn-sm btn-outline-warning"
            title="En attente"
        >
            …
        </button>

    </form>

    <form
        method="POST"
        action="{{ route('admin.participants.absent', $participant) }}"
    >
        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="btn btn-sm btn-outline-danger"
            title="Absent"
        >
            ✕
        </button>

    </form>

</div>