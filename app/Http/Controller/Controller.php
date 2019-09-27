<?php

namespace App\Http\Controller;

use App\Base\Controller as BaseController;
use App\Http\Render\View;

abstract class Controller extends BaseController
{
    /**
     * 文件渲染殷勤
     *
     * @var View
     */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->view = container()->view;
    }

    /**
     * 渲染模板
     *
     * @param string $file
     * @param array $params
     * @return false|string
     * @throws \App\Http\Exception\ViewException
     * @throws \Throwable
     */
    protected function render($file, $params = [])
    {
        return $this->view->render($file, $params);
    }

    /**
     * 页面重定向
     *
     * @param string $url
     */
    protected function redirect($url)
    {
        header("Location: /{$url}");
        exit;
    }
}
