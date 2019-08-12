<?php

use Doctrine\ORM\Tools\Setup;
use Symfony\Component\HttpFoundation\Request;
use function FastRoute\simpleDispatcher;
use Doctrine\ORM\EntityManager;

return [
    'http_service' => function () {
        $this->container['request'] = $this->request = Request::createFromGlobals();
        $this->container['entityManager'] = EntityManager::create(config('mysql'), Setup::createAnnotationMetadataConfiguration([APP_PATH . '/Http/Entity'], true, null, null, false));
        $this->container['routeDispatcher'] = $this->routeDispatcher = simpleDispatcher($this->getConfig()->get('route'));
    },
    'http_bootstrap' => function () {
        $this->addMiddleware('echo');
    }
];
