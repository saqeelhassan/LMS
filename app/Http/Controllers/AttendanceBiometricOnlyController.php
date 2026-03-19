<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Redirects users who try to access decommissioned manual/QR attendance URLs
 * to an info page: attendance is biometric-only.
 */
class AttendanceBiometricOnlyController extends Controller
{
    public function info(): View
    {
        return view('attendance-biometric-only');
    }

    public function redirectHere(): RedirectResponse
    {
        return redirect()->route('attendance.biometric-only')
            ->with('info', 'Attendance is only recorded via Biometric Scanner at the Institute.');
    }
}
