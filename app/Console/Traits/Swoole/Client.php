<?php

namespace App\Console\Traits\Swoole;

use Swoole\Client as SwooleClient;
use Swoole\Coroutine\MySQL;

trait Client
{
    /**
     * Swoole Sync Tcp Client
     *
     * @var SwooleClient
     */
    private $syncTcpClient;

    /**
     * 获取Swoole Sync Tcp Client
     *
     * @return SwooleClient
     */
    public function getSyncTcpClient(): SwooleClient
    {
        if (!$this->syncTcpClient) {
            $this->syncTcpClient = new SwooleClient(SWOOLE_SOCK_TCP);
        }

        return $this->syncTcpClient;
    }

    /**
     * Swoole Async Tcp Client
     *
     * @var SwooleClient
     */
    private $asyncTcpClient;

    /**
     * 获取Swoole Async Tcp Client
     *
     * @return SwooleClient
     */
    public function getAsyncTcpClient(): SwooleClient
    {
        if (!$this->asyncTcpClient) {
            $this->asyncTcpClient = new SwooleClient(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        }

        return $this->asyncTcpClient;
    }
}
