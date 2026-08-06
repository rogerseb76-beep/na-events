<?php

namespace App\Http\Requests\Admin;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
            ],
            'event_date' => [
                'required',
                'date',
            ],
            'location' => [
                'required',
                'string',
                'max:255',
            ],
            'status' => [
                'required',
                Rule::in([
                    Event::STATUS_DRAFT,
                    Event::STATUS_PUBLISHED,
                    Event::STATUS_FULL,
                    Event::STATUS_CLOSED,
                    Event::STATUS_ARCHIVED,
                ]),
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' =>
                'Le titre de l’événement est obligatoire.',
            'description.required' =>
                'La description est obligatoire.',
            'event_date.required' =>
                'La date de l’événement est obligatoire.',
            'event_date.date' =>
                'La date indiquée est invalide.',
            'location.required' =>
                'Le lieu de l’événement est obligatoire.',
            'status.required' =>
                'Le statut de l’événement est obligatoire.',
            'status.in' =>
                'Le statut choisi est invalide.',
        ];
    }
}
