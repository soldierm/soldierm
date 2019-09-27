<?php

namespace App;

use Pimple\Container as PimpleContainer;

/**
 * @property \App\Base\App $app 应用
 * @property \Noodlehaus\Config $config 配置
 * @property \FastRoute\Dispatcher $routeDispatcher 只在fastcgi模式下有效
 * @property \Symfony\Component\HttpFoundation\Request $request 只在fastcgi模式下有效
 * @property \Symfony\Component\HttpFoundation\Response $response 只在fastcgi模式下有效
 * @property \Doctrine\Common\Cache\Cache $cache 缓存
 * @property \App\Base\User $user 用户信息组件
 * @property bool $debug
 * @property string $version
 * @property string $author
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

    /**
     * @see Container::offsetGet()
     */
    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @see Container::offsetSet()
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }
}
