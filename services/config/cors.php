<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['*'],

    'allowed_methods' => ['GET','POST'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => ['/(.*)\.wip/','/(.*)\.test/'],

    'allowed_headers' => ['content-type','accept','x-custom-header'],

    'exposed_headers' => ['x-custom-response-header'],

    'max_age' => 60,

    'supports_credentials' => false,

];
