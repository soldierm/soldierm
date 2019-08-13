<?php

namespace App\Console\Command;

use App\Base\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:create-users')
            ->setDescription('Creates new users.')
            ->setHelp("This command allows you to create users...");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');
    }
}
