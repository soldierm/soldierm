<?php

namespace App\Console\Command\EasySwoole;

use App\Base\Command;
use EasySwoole\EasySwoole\Command\CommandRunner;
use Phar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class EasySwooleCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->bootstrap();
    }

    /**
     * 初始化
     * 1.设置EasySwoolechangl
     * 2.载入配置
     */
    protected function bootstrap()
    {
        $this->define();

        if (file_exists(EASYSWOOLE_ROOT . '/bootstrap.php')) {
            require_once EASYSWOOLE_ROOT . '/bootstrap.php';
        }
    }

    /**
     * 设置EasySwoole常量
     */
    protected function define()
    {
        defined('IN_PHAR') or define('IN_PHAR', (bool)Phar::running(false));
        defined('RUNNING_ROOT') or define('RUNNING_ROOT', realpath(getcwd()));
        defined('EASYSWOOLE_ROOT') or define('EASYSWOOLE_ROOT', ROOT_PATH . '/vendor/bin');
    }

    /**
     * 运行EasySwoole命令
     *
     * @param string|array $command
     * @return string|null
     */
    protected function runSwoole($command)
    {
        if (!is_array($command)) {
            $command = [$command];
        }
        return CommandRunner::getInstance()->run($command);
    }
}
