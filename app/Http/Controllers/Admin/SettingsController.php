<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $registrationState =
            AppSetting::registrationState();

        $messages = [
            'open' => AppSetting::getValue(
                'registration_message_open',
                'Les inscriptions sont ouvertes.'
            ),
            'live' => AppSetting::getValue(
                'registration_message_live',
                'La journée est en cours. Les réservations sont closes.'
            ),
            'closed' => AppSetting::getValue(
                'registration_message_closed',
                'Les inscriptions sont actuellement fermées.'
            ),
        ];

        return view(
            'admin.settings.edit',
            compact(
                'registrationState',
                'messages'
            )
        );
    }

    public function update(
        Request $request
    ): RedirectResponse {
        $validated = $request->validate([
            'registration_state' => [
                'required',
                Rule::in([
                    'open',
                    'live',
                    'closed',
                ]),
            ],
            'registration_message_open' => [
                'required',
                'string',
                'max:1000',
            ],
            'registration_message_live' => [
                'required',
                'string',
                'max:1000',
            ],
            'registration_message_closed' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        foreach ($validated as $key => $value) {
            AppSetting::setValue($key, $value);
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with(
                'success',
                'Les paramètres des inscriptions ont été enregistrés.'
            );
    }
}
