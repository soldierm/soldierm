<?php

namespace App\Http\Module\EasySwoole\Controller;

use EasySwoole\Http\AbstractInterface\Controller;

class TestController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function index()
    {
        $this->response()->write('<h1>Hello World!</h1>');
    }
}
