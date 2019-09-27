<?php

namespace App\Http\Controller;

class MasterController extends Controller
{
    /**
     * 首页
     *
     * @return false|string
     * @throws \App\Http\Exception\ViewException
     * @throws \Throwable
     */
    public function __invoke()
    {
        return 'login login';
    }
}
