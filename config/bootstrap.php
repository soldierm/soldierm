<?php

use App\Console\Command\HttpServerCommand;
use App\Http\Auth\User as UserAuth;
use App\Http\Render\View;
use Doctrine\Common\Cache\PredisCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Predis\Client;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpFoundation\Request;
use function FastRoute\simpleDispatcher;

return [
    'api_service' => function () {
        $this->container['request'] = $this->request = Request::createFromGlobals();
        $this->container['entityManager'] = EntityManager::create(config('mysql'), Setup::createAnnotationMetadataConfiguration([APP_PATH . '/Api/Entity'], true, null, null, false));
        $this->container['cache'] = new PredisCache(new Client(config('cache')['parameters'], config('cache')['options']));
    },
    'api_bootstrap' => function () {
        $this->routeDispatcher = simpleDispatcher(config('api_route'));
        $this->addMiddleware('echo');
    },
    'http_service' => function () {
        $this->container['request'] = $this->request = Request::createFromGlobals();
        $this->container['view'] = new View();
        $this->container['entityManager'] = EntityManager::create(config('mysql'), Setup::createAnnotationMetadataConfiguration([APP_PATH . '/Http/Entity'], true, null, null, false));
        $this->container['cache'] = new PredisCache(new Client(config('cache')['parameters'], config('cache')['options']));
        $this->container['user'] = new UserAuth();
    },
    'http_bootstrap' => function () {
        $this->container['routeDispatcher'] = $this->routeDispatcher = simpleDispatcher(config('http_route'));
        $this->addMiddleware('echo')
            ->addMiddleware('auth');
        session_start();
    },
    'console_service' => function () {
    },
    'console_bootstrap' => function () {
        $this->symfonyApplication = new Application('Soldierm', container()->version);
        $this->addCommand(new HttpServerCommand());
    }
];
