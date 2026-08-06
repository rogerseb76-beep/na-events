<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function present(
        Participant $participant
    ): RedirectResponse {

        $participant->update([
            'attendance_status' => 'present',
            'checked_in_at' => Carbon::now(),
        ]);

        return back()->with(
            'success',
            'Le participant a été marqué présent.'
        );
    }

    public function absent(
        Participant $participant
    ): RedirectResponse {

        $participant->update([
            'attendance_status' => 'absent',
            'checked_in_at' => null,
        ]);

        return back()->with(
            'success',
            'Le participant a été marqué absent.'
        );
    }

    public function pending(
        Participant $participant
    ): RedirectResponse {

        $participant->update([
            'attendance_status' => 'pending',
            'checked_in_at' => null,
        ]);

        return back()->with(
            'success',
            'Le participant est remis en attente.'
        );
    }
}