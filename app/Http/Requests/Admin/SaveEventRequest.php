<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaveEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'event_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'location' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de l’événement est obligatoire.',
            'description.required' => 'La description est obligatoire.',
            'event_date.required' => 'La date de l’événement est obligatoire.',
            'event_date.date' => 'La date indiquée est invalide.',
            'event_date.after_or_equal' => 'La date de l’événement ne peut pas être antérieure à aujourd’hui.',
            'location.required' => 'Le lieu de l’événement est obligatoire.',
        ];
    }
}