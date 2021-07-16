<?php

return [
    // 访问域名 https://localhost
    'domain'   => env('APP_URL'),
    // 路径部分，用于定位路由 https://localhost/s
    'path'     => 's',
    // 数据库配置
    'database' => [
        'connection' => env('DB_CONNECTION'),
        'table'      => 'short_url',
    ],
];
