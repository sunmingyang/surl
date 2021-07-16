<?php

return [
    'path'         => 's',
    'domain'       => env('APP_URL'),
    'request_name' => 'url',
    'expires_name' => 'expires_at',
    'database'     => [
        'connection' => env('DB_CONNECTION'),
        'table'      => 'short_url',
    ],
];
