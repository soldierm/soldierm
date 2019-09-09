<?php

namespace App\Console\Command;

use App\Base\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ForkCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:fork')
            ->setDescription('Fork Process.')
            ->setHelp("This command allows you to fork process...");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start Fork...');

        $childProcessPid = pcntl_fork();

        switch ($childProcessPid) {
            case -1:
                $output->writeln('Something Wrong...');
                break;
            case 0:
                $output->writeln('I\'m ChildProcess, My Pid : ' . $childProcessPid);
                break;
            default:
                $output->writeln('I\'m ParentProcess, My Pid : ' . $childProcessPid);
                break;
        }
    }
}
