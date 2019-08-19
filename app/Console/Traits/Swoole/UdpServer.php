<?php

namespace App\Console\Traits\Swoole;

use Swoole\Server;

trait UdpServer
{
    /**
     * Swoole Tcp Server
     *
     * @var Server
     */
    private $udpServer;

    /**
     * 获取Swoole Tcp Server
     *
     * @param array $config
     * @param bool $udp6
     * @return Server
     */
    public function getTcpServer(array $config = [], bool $udp6 = false): Server
    {
        $default = [
            'host' => '127.0.0.1',
            'port' => 9501,
            'mod' => SWOOLE_PROCESS
        ];
        if (!$this->udpServer) {
            $config = array_merge($default, $config);
            $this->tcpServer = new Server($config['host'], $config['port'], $config['mod'], $udp6 ? SWOOLE_SOCK_UDP : SWOOLE_SOCK_UDP6);
        }

        return $this->udpServer;
    }
}
