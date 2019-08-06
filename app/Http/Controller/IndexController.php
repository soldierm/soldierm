<?php

namespace App\Http\Controller;

use App\Base\BaseController;

class IndexController extends BaseController
{
    /**
     * @return string
     */
    public function __invoke()
    {
        return 'hello world';
    }
}