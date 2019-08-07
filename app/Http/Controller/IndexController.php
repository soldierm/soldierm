<?php

namespace App\Http\Controller;

use App\Base\Controller;

class IndexController extends Controller
{
    /**
     * @return string
     */
    public function __invoke()
    {
        return 'hello world';
    }
}