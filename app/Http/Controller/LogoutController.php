<?php

namespace App\Http\Controller;

class LogoutController extends Controller
{
    /**
     * @return false|string
     * @throws \App\Http\Exception\ViewException
     * @throws \Throwable
     */
    public function __invoke()
    {
        session_destroy();

        return $this->redirect('index');
    }
}
