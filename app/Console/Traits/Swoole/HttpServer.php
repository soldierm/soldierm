<?php

namespace App\Console\Traits\Swoole;

use Swoole\Http\Server;

trait HttpServer
{
    /**
     * Swoole Http Server
     *
     * @var Server
     */
    private $httpServer;

    /**
     * 获取Swoole Http Server
     *
     * @return Server
     */
    public function getHttpServer(array $config = [])
    {
        $default = [
            'host' => '127.0.0.1',
            'port' => 9501,
            'mod' => SWOOLE_PROCESS,
            'sock_type' => SWOOLE_SOCK_TCP
        ];
        if (!$this->httpServer) {
            $config = array_merge($default, $config);
            $this->httpServer = new Server($config['host'], $config['port'], $config['mod'], $config['sock_type']);
        }

        return $this->httpServer;
    }
}
