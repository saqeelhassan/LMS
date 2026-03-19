<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DSIMT Admission Form Database
    |--------------------------------------------------------------------------
    | Used by standalone admission form scripts (public/Dsimt-lms-assets/Admission_Form/).
    | Credentials are read from .env so they are never stored in the web root.
    |
    */

    'host' => env('DB_DSIMT_HOST', '127.0.0.1'),
    'port' => env('DB_DSIMT_PORT', '3306'),
    'database' => env('DB_DSIMT_DATABASE', ''),
    'username' => env('DB_DSIMT_USERNAME', ''),
    'password' => env('DB_DSIMT_PASSWORD', ''),

];
