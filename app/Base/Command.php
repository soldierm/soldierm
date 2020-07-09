<?php

namespace App\Base;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand
{
    /**
     * Exit
     *
     * @var int
     */
    public const SUCCESS = 0;
    public const FAILURE = 1;

    /**
     * 输入
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * 输出
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * {@inheritDoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }
}
