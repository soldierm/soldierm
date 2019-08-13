<?php

use Doctrine\Common\Cache\PredisCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Predis\Client;
use Symfony\Component\HttpFoundation\Request;
use function FastRoute\simpleDispatcher;

return [
    'http_service' => function () {
        $this->container['request'] = $this->request = Request::createFromGlobals();
        $this->container['entityManager'] = EntityManager::create(config('mysql'), Setup::createAnnotationMetadataConfiguration([APP_PATH . '/Http/Entity'], true, null, null, false));
        $this->container['cache'] = new PredisCache(new Client(config('cache')['parameters'], config('cache')['options']));
    },
    'http_bootstrap' => function () {
        $this->routeDispatcher = simpleDispatcher($this->getConfig()->get('route'));
        $this->addMiddleware('echo');
    }
];
