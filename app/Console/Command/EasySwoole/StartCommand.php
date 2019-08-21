<?php

namespace App\Console\Command\EasySwoole;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartCommand extends EasySwooleCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('easyswoole:start')
            ->setDescription('Start EasySwoole.')
            ->setHelp("This command allows you to start easyswoole...");
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        echo $this->runSwoole('start');
    }
}
