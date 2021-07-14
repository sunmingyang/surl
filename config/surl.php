<?php

return [
    'path'         => 's',
    'domain'       => env('APP_URL'),
    'request_name' => 'url',
    'database'     => [
        'connection' => env('DB_CONNECTION'),
        'table'      => 'short_url',
    ],
];
