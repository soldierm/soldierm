<?php

namespace App\Base;

use App\Container;
use Noodlehaus\Config;

abstract class App
{
    /**
     * 容器
     *
     * @var Container
     */
    protected $container;

    /**
     * 配置
     *
     * @var Config
     */
    protected $config;

    /**
     * 单例
     *
     * @var App
     */
    protected static $app;

    /**
     * AbstractApp constructor.
     * @param array $config
     * @param Container|null $container
     */
    public function __construct($config = [])
    {
        $this->container = Container::instance();
        $this->config = new Config($config);
        $this->init();
    }

    /**
     * 初始化方法
     *
     * @return void
     */
    protected function init()
    {
        $this->container['app'] = $this;
        $this->container['config'] = $this->config;
    }

    /**
     * 运行
     *
     * @return mixed
     */
    abstract public function run();

    /**
     * 获取单例
     *
     * @return $this
     */
    public function getInstance()
    {
        return $this->container['app'];
    }

    /**
     * 获取容器
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * 获取配置
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->container['config'];
    }
}