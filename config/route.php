<?php

use App\Http\Controller as HttpController;
use App\Api\Controller as ApiController;

return [
    'api_route' => function (FastRoute\RouteCollector $r) {
        $r->get('/', new ApiController\IndexController());
        $r->get('/users', new ApiController\ListUserController());
    },
    'http_route' => function (FastRoute\RouteCollector $r) {
        $r->get('/', new HttpController\IndexController());
    },
];
