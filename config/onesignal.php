<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OneSignal App ID
    |--------------------------------------------------------------------------
    | This is your OneSignal Application ID
    | It is used to identify your app on OneSignal servers.
    |
    */

    'app_id' => env('ONESIGNAL_APP_ID', ''),


    /*
    |--------------------------------------------------------------------------
    | OneSignal REST API Key
    |--------------------------------------------------------------------------
    | This key is used by your Laravel backend to send notifications
    | NEVER expose this key in frontend or GitHub
    |
    */

    'api_key' => env('ONESIGNAL_REST_API_KEY', ''),

];
