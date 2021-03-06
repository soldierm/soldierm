<?php

use App\Container;
use App\Api\App;

(function () {
    require './../../vendor/autoload.php';

    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT_PATH', dirname(dirname(__DIR__)));
    define('APP_PATH', ROOT_PATH . DS . 'app');
    define('CONFIG_PATH', ROOT_PATH . DS . 'config');

    Container::instance([
        'version' => '0.0.1',
        'author' => 'zhouyang',
        'debug' => true,
    ]);

    $app = new App(CONFIG_PATH);
    $app->run();
})();
