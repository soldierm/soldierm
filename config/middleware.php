<?php

return [
    'api_middleware' => [
        'auth' => 'App\\Api\\Middleware\\AuthMiddleware',
        'echo' => 'App\\Api\\Middleware\\JsonEchoMiddleware'
    ],
    'http_middleware' => [
        'echo' => 'App\\Http\\Middleware\\HtmlEchoMiddleware'
    ]
];
