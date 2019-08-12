<?php

use App\Container;

if (!function_exists('container')) {
    /**
     * 获取容器
     *
     * @return Container
     */
    function container()
    {
        return Container::instance();
    }
}

if (!function_exists('app')) {
    /**
     * 获取应用实例
     *
     * @return \App\Base\App
     */
    function app()
    {
        return container()->app;
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

if (!function_exists('config')) {
    /**
     * 获取配置
     *
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    function config($key, $default = null)
    {
        return container()->config->get($key, $default);
    }
}
