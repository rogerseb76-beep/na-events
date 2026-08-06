<?php

namespace App\Http\Requests\Admin;

use App\Models\EventSession;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SaveEventSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],

            'start_time' => [
                'required',
                'date_format:H:i',
            ],

            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
                'max:255',
            ],

            'display_order' => [
                'required',
                'integer',
                'min:1',
                'max:255',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $session = $this->route('session');

                if (! $session instanceof EventSession) {
                    return;
                }

                $participantsCount = $session->participants()->count();
                $requestedCapacity = (int) $this->input('capacity');

                if ($requestedCapacity < $participantsCount) {
                    $validator->errors()->add(
                        'capacity',
                        "La capacité ne peut pas être inférieure au nombre actuel de participants ({$participantsCount})."
                    );
                }

                if (
                    ! $this->boolean('is_active')
                    && $participantsCount > 0
                ) {
                    $validator->errors()->add(
                        'is_active',
                        'Une session contenant des participants ne peut pas être désactivée.'
                    );
                }
            },
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' =>
                'Le titre de la session est obligatoire.',

            'start_time.required' =>
                'L’heure de début est obligatoire.',

            'start_time.date_format' =>
                'L’heure de début est invalide.',

            'end_time.required' =>
                'L’heure de fin est obligatoire.',

            'end_time.date_format' =>
                'L’heure de fin est invalide.',

            'end_time.after' =>
                'L’heure de fin doit être postérieure à l’heure de début.',

            'capacity.required' =>
                'La capacité est obligatoire.',

            'capacity.integer' =>
                'La capacité doit être un nombre entier.',

            'capacity.min' =>
                'La capacité doit être au minimum de 1.',

            'capacity.max' =>
                'La capacité ne peut pas dépasser 255 participants.',

            'display_order.required' =>
                'L’ordre d’affichage est obligatoire.',

            'display_order.integer' =>
                'L’ordre d’affichage doit être un nombre entier.',

            'display_order.min' =>
                'L’ordre d’affichage doit être au minimum de 1.',
        ];
    }
}