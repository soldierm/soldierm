<?php

namespace App\Http\Controller;

class IndexController extends Controller
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
        return $this->render('index/index', [
            'version' => $this->container['version'],
            'author' => $this->container['author'],
            'datetime' => date('Y-m-d H:i:s')
        ]);
    }
}
