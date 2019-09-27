<?php

namespace App\Base;

use App\Container;
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

    /**
     * 是否是Get请求
     *
     * @return bool
     */
    protected function isGet()
    {
        return $this->request->getMethod() === 'GET';
    }

    /**
     * 是否是Post请求
     *
     * @return bool
     */
    protected function isPost()
    {
        return $this->request->getMethod() === 'POST';
    }

    /**
     * 是否是Put请求
     *
     * @return bool
     */
    protected function isPut()
    {
        return $this->request->getMethod() === 'PUT';
    }

    /**
     * 是否是Patch请求
     *
     * @return bool
     */
    protected function isPatch()
    {
        return $this->request->getMethod() === 'PATCH';
    }

    /**
     * 是否是Delete请求
     *
     * @return bool
     */
    protected function isDelete()
    {
        return $this->request->getMethod() === 'DELETE';
    }

    /**
     * 是否是Head请求
     *
     * @return bool
     */
    protected function isHead()
    {
        return $this->request->getMethod() === 'HEAD';
    }

    /**
     * 是否是Delete请求
     *
     * @return bool
     */
    protected function isOptions()
    {
        return $this->request->getMethod() === 'DELETE';
    }
}
