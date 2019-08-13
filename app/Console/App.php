<?php

namespace App\Console;

use App\Base\App as BaseApp;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class App extends BaseApp
{
    /**
     * Symfony Console应用
     *
     * @var Application
     */
    protected $symfonyApplication;

    /**
     * {@inheritDoc}
     */
    protected function init()
    {
        parent::init();

        config('console_service')->call($this);
        config('console_bootstrap')->call($this);
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $this->symfonyApplication->run();
    }

    /**
     * 添加命令
     *
     * @param Command $command
     * @return $this
     */
    public function addCommand(Command $command)
    {
        $this->symfonyApplication->add($command);

        return $this;
    }
}
