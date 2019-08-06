<?php

use App\Http\Controller;

return [
    'route' => function (FastRoute\RouteCollector $r) {
        $r->addRoute('GET', '/', new Controller\IndexController());
    }
];