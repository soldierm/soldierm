<?php

return [
    'middleware' => [
        'auth' => 'App\\Http\\Middleware\\AuthMiddleware',
        'echo' => 'App\\Http\\Middleware\\JsonEchoMiddleware'
    ]
];