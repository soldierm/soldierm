<?php

namespace App\Http\Exception;

use Whoops\Handler\Handler;
use Whoops\Util\TemplateHelper;

class SbAdminErrorHandler extends Handler
{
    /**
     * 错误页面模板
     *
     * @var string
     */
    private $template = APP_PATH . '/Http/View/error.php';

    /**
     * @var TemplateHelper
     */
    private $templateHelper;

    /**
     * PrettyErrorHandler constructor.
     */
    public function __construct()
    {
        $this->templateHelper = new TemplateHelper();
    }

    /**
     * {@inheritDoc}
     */
    public function handle()
    {
        $vars = [
            'allMinCss' => $this->getPublicResource('vendor/fontawesome-free/css/all.min.css'),
            'sbAdmin2Css' => $this->getPublicResource('css/sb-admin-2.min.css'),
            'jqueryJs' => $this->getPublicResource('vendor/jquery/jquery.min.js'),
            'bootstrapBundleJs' => $this->getPublicResource('vendor/bootstrap/js/bootstrap.bundle.min.js'),
            'jqueryEasingJs' => $this->getPublicResource('vendor/jquery-easing/jquery.easing.min.js'),
            'sbAdmin2Js' => $this->getPublicResource('js/sb-admin-2.min.js'),
        ];
        $this->templateHelper->setVariables($vars);
        $this->templateHelper->render($this->template);

        return Handler::QUIT;
    }

    /**
     * 获取资源
     *
     * @param string $file
     * @return string
     */
    private function getPublicResource($file)
    {
        return file_get_contents(ROOT_PATH . '/public/http/resource/' . $file);
    }

    /**
     * 设置模板文件位置
     *
     * @param string $template
     * @throws ViewException
     */
    public function setTemplate($template)
    {
        if (!file_exists($template)) {
            throw new ViewException(sprintf('Cant\'t find template: %s', $template));
        }

        $this->template = $template;
    }
}
