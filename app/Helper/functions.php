<?php

use App\Container;

if (!function_exists('app')) {
    /**
     * 获取应用实例
     *
     * @return \App\Base\App
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

if (!function_exists('http_format')) {
    /**
     * 格式化抛出
     *
     * @param int $code
     * @param string $msg
     * @param $data
     * @return array
     */
    function http_format(int $code, string $msg, $data)
    {
        return compact('code', 'msg', 'data');
    }
}