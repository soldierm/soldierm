<?php

namespace App\Console\Command\EasySwoole;

use App\Base\Command;
use EasySwoole\EasySwoole\Command\CommandRunner;
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
        define('IN_PHAR', false);
        define('RUNNING_ROOT', realpath(getcwd()));
        define('EASYSWOOLE_ROOT', CONFIG_PATH . '/easyswoole');
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
