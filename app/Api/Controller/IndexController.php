<?php

namespace App\Api\Controller;

class IndexController extends Controller
{
    /**
     * 首页控制器
     *
     * @return mixed
     */
    public function __invoke()
    {
        return [
            'version' => $this->container['version'],
            'author' => $this->container['author'],
            'datetime' => date('Y-m-d H:i:s')
        ];
    }
}
