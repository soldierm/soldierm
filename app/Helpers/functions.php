<?php

use App\Container;

if (!function_exists('app')) {
    /**
     * 获取应用实例
     *
     * @return \App\Base\BaseApp
     */
    function app()
    {
        return Container::instance()->app;
    }
}

if (!function_exists('request')) {
    /**
     * 获取请求
     *
     * @return \Symfony\Component\HttpFoundation\Request
     */
    function request()
    {
        return Container::instance()->request;
    }
}