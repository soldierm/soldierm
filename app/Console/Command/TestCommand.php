<?php

namespace App\Console\Command;

use App\Base\Command;
use App\Console\Traits\Swoole\Server;
use Swoole\Server as SwooleServer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    use Server;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('swoole:tcpserver')
            ->setDescription('Creates swoole tcp server.')
            ->setHelp("This command allows you to swoole tcp server...");
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
