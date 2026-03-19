<?php

return [
    /*
    |--------------------------------------------------------------------------
    | ZKTeco uFace / device IP and port
    |--------------------------------------------------------------------------
    | The device must be reachable from the Laravel server (same network or VPN).
    | Default ZKTeco port is 4370 (UDP).
    */
    'ip' => env('ZKTECO_IP', '192.168.1.201'),
    'port' => (int) env('ZKTECO_PORT', 4370),

    /*
    |--------------------------------------------------------------------------
    | Device ID (optional)
    |--------------------------------------------------------------------------
    | Stored in biometric_logs.device_id for multi-device setups.
    */
    'device_id' => env('ZKTECO_DEVICE_ID', null),
];
