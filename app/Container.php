<?php

namespace App;

use Pimple\Container as PimpleContainer;

/**
 * @property \App\Base\BaseApp $app
 * @property \Noodlehaus\Config $config
 * @property \FastRoute\Dispatcher $routeDispatcher 只在fastcgi模式下有效
 * @property \Symfony\Component\HttpFoundation\Request $request 只在fastcgi模式下有效
 * @property \Symfony\Component\HttpFoundation\Response $response 只在fastcgi模式下有效
 * @property bool $debug
 */
class Container extends PimpleContainer
{
    /**
     * 单例
     *
     * @var Container
     */
    private static $instance;

    /**
     * 获取单例
     *
     * @param array $values
     * @return Container
     */
    public static function instance(array $values = [])
    {
        if (!self::$instance) {
            self::$instance = new static($values);
        }

        return self::$instance;
    }
}