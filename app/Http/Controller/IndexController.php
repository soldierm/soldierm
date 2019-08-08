<?php

namespace App\Http\Controller;

use App\Base\Controller;

class IndexController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this->addMiddleware('test-before')
            ->addMiddleware('test-after');
    }

    /**
     * 首页控制器
     *
     * @return array
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