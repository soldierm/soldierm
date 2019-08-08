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
     * Controller constructor.
     */
    public function __construct()
    {
        $this->app = app();
        $this->container = $this->app->getContainer();
        $this->request = $this->container->request;
    }
}