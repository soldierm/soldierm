<?php

namespace App\Console\Command;

use App\Base\Command;
use App\Console\Traits\Swoole\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HttpServerCommand extends Command
{
    use Server;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('httpserver')
            ->setDescription('Manage swoole tcp server.')
            ->setHelp("This command allows you to manage swoole http server...");

        $this->addOption('start', 's', InputOption::VALUE_OPTIONAL, 'start http server');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = $this->getHttpServer(['host' => '0.0.0.0']);
        $server->set([
            'worker_num' => 4,
            'backlog' => 128,
            'max_request' => 5,
            'dispatch_mode' => 1,
            'reactor_num' => 2,
        ]);
        $server->on('request', function(Request $request, Response $response) {
            $response->write('<h2>Hello Swoole</h2>');
        });
        $server->start();
    }
}
