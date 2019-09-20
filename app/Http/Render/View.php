<?php

namespace App\Http\Render;

use App\Http\Exception\ViewException;
use Throwable;

class View
{
    /**
     * 渲染文件后缀
     *
     * @var string
     */
    private const FILE_SUFFIX = '.php';

    /**
     * 渲染文件目录
     *
     * @var string
     */
    private const VIEW_PATH = 'View';

    /**
     * 渲染模板
     *
     * @param string $file
     * @param array $params
     * @return false|string
     * @throws Throwable
     * @throws ViewException
     */
    public function render($file, $params = [])
    {
        $file = $this->findFile($file);
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($params, EXTR_OVERWRITE);
        try {
            require $file;
            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }

    /**
     * 查找模板文件
     *
     * @param string $file
     * @return string
     * @throws ViewException
     */
    private function findFile($file)
    {
        $file = APP_PATH . '/Http/' . self::VIEW_PATH . DS . $file . self::FILE_SUFFIX;
        if (!file_exists($file)) {
            throw new ViewException(sprintf('Can\'t find file: %s', $file));
        }
        return $file;
    }
}
