<?php

namespace App\Console\Command;

use App\Base\Command;
use App\Console\Traits\Swoole\TcpServer;
use Swoole\Server;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    use TcpServer;

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
        $tcpServer = $this->getTcpServer();
        $tcpServer->on('connect', [$this, 'onConnect']);
        $tcpServer->on('receive', [$this, 'onReceive']);
        $tcpServer->on('close', [$this, 'onClose']);
    }

    private function onConnect(Server $server, $fd)
    {
        echo get_class($server), PHP_EOL;
        echo 'fd:', $fd, PHP_EOL;
    }

    private function onReceive(Server $server, $fd, $from, $data)
    {
        echo 'from:', $from, PHP_EOL;
        $server->send($fd, 'Receive data :' . $data);
    }

    private function onClose(Server $server, $fd)
    {
        echo 'Goodbye fd:', $fd, PHP_EOL;
    }
}
