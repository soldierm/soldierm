<?php

namespace App\Base;

use App\Container;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    /**
     * 应用
     *
     * @var App
     */
    protected $app;

    /**
     * 容器
     *
     * @var Container
     */
    protected $container;

    /**
     * 请求
     *
     * @var Request
     */
    protected $request;

    /**
     * 控制器请求中间件
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->app = app();
        $this->container = $this->app->getContainer();
        $this->request = $this->container->request;
    }

    /**
     * 添加控制器中间件
     *
     * @param $middleware
     * @return $this
     */
    public function addMiddleware($middleware)
    {
        $this->middleware[] = $middleware;

        return $this;
    }

    /**
     * 获取控制器中间件s
     *
     * @return array
     */
    public function middleware()
    {
        return $this->middleware;
    }
}
