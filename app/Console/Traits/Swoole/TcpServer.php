<?php

namespace App\Console\Traits\Swoole;

use Swoole\Server;

trait TcpServer
{
    /**
     * Swoole Tcp Server
     *
     * @var Server
     */
    private $tcpServer;

    /**
     * 获取Swoole Tcp Server
     *
     * @param array $config
     * @param bool $tcp6
     * @return Server
     */
    public function getTcpServer(array $config = [], bool $tcp6 = false): Server
    {
        $default = [
            'host' => '127.0.0.1',
            'port' => 9501,
            'mod' => SWOOLE_PROCESS
        ];
        if (!$this->tcpServer) {
            $config = array_merge($default, $config);
            $this->tcpServer = new Server($config['host'], $config['port'], $config['mod'], $tcp6 ? SWOOLE_SOCK_TCP : SWOOLE_SOCK_TCP6);
        }

        return $this->tcpServer;
    }
}
