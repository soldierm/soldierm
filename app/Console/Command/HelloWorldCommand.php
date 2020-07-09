<?php

namespace App\Console\Command;

use App\Base\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorldCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:test')
            ->setDescription('Hello World.')
            ->setHelp("Congratulations...");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Congratulations...');

        return self::SUCCESS;
    }
}
