<?php

use App\Http\Controllers\Api\BiometricPunchController;
use App\Http\Controllers\Api\ZkTecoPushController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Biometric device API (no session / no CSRF)
|--------------------------------------------------------------------------
| Devices send POST with token in header. See BIOMETRIC_API_TOKEN in .env
| Optional: BIOMETRIC_DEVICE_IDS=DEVICE001,DEVICE002 to allowlist devices.
| Throttled to 60/min per IP to reduce brute-force and DDoS risk.
*/

Route::post('/biometric/punch', BiometricPunchController::class)
    ->middleware([
        'throttle:60,1',
        \App\Http\Middleware\ValidateBiometricToken::class,
    ])
    ->name('api.biometric.punch');

/*
|--------------------------------------------------------------------------
| ZKTeco uFace / iClock native push (cdata ATTLOG)
|--------------------------------------------------------------------------
| Configure device push URL: https://your-lms.com/api/biometric/zkteco?api_token=TOKEN
| Optional: &SN=DEVICE_SERIAL. Body: tab-separated lines (PIN, DateTime, Status, VerifyType).
*/
Route::post('/biometric/zkteco', ZkTecoPushController::class)
    ->middleware([
        'throttle:60,1',
        \App\Http\Middleware\ValidateBiometricToken::class,
    ])
    ->name('api.biometric.zkteco');
