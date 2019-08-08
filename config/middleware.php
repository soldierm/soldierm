<?php

return [
    'middleware' => [
        'auth' => 'App\\Http\\Middleware\\AuthMiddleware',
        'test-before' => 'App\\Http\\Middleware\\TestBeforeMiddleware',
        'test-after' => 'App\\Http\\Middleware\\TestAfterMiddleware',
    ]
];