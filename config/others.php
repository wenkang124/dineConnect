<?php

return [
    'fcm' => [
        'enabled' => true,
        'url' => env('FCM_ENDPOINT'),
        'secret' => env('FCM_SECRET'),
    ]
];
