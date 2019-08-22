<?php

namespace App\Console\Traits\Swoole;

use Swoole\Http\Server as HttpServer;
use Swoole\Server as SwooleServer;
use Swoole\WebSocket\Server as WebSocketServer;

trait Server
{
    /**
     * Swoole Http Server
     *
     * @var HttpServer
     */
    private $httpServer;

    /**
     * 获取Swoole Http Server
     *
     * @return HttpServer
     */
    public function getHttpServer(array $config = []): HttpServer
    {
        $default = [
            'host' => '0.0.0.0',
            'port' => 9501,
            'mod' => SWOOLE_PROCESS,
            'sock_type' => SWOOLE_SOCK_TCP
        ];
        if (!$this->httpServer) {
            $config = array_merge($default, $config);
            $this->httpServer = new HttpServer($config['host'], $config['port'], $config['mod'], $config['sock_type']);
        }

        return $this->httpServer;
    }

    /**
     * Swoole WebSocket Server
     *
     * @var WebSocketServer
     */
    private $webSocketServer;

    /**
     * 获取Swoole WebSocket Server
     *
     * @return WebSocketServer
     */
    public function getWebSocketServer(array $config = []): WebSocketServer
    {
        $default = [
            'host' => '0.0.0.0',
            'port' => 9501,
            'mod' => SWOOLE_PROCESS,
            'sock_type' => SWOOLE_SOCK_TCP
        ];
        if (!$this->webSocketServer) {
            $config = array_merge($default, $config);
            $this->webSocketServer = new WebSocketServer($config['host'], $config['port'], $config['mod'], $config['sock_type']);
        }

        return $this->webSocketServer;
    }

    /**
     * Swoole Tcp Server
     *
     * @var SwooleServer
     */
    private $tcpServer;

    /**
     * 获取Swoole Tcp Server
     *
     * @param array $config
     * @param bool $tcp6
     * @return SwooleServer
     */
    public function getTcpServer(array $config = [], bool $tcp6 = false): SwooleServer
    {
        $default = [
            'host' => '0.0.0.0',
            'port' => 9501,
            'mod' => SWOOLE_PROCESS
        ];
        if (!$this->tcpServer) {
            $config = array_merge($default, $config);
            $this->tcpServer = new SwooleServer($config['host'], $config['port'], $config['mod'], $tcp6 ? SWOOLE_SOCK_TCP : SWOOLE_SOCK_TCP6);
        }

        return $this->tcpServer;
    }

    /**
     * Swoole Udp Server
     *
     * @var SwooleServer
     */
    private $udpServer;

    /**
     * 获取Swoole Udp Server
     *
     * @param array $config
     * @param bool $udp6
     * @return SwooleServer
     */
    public function getUdpServer(array $config = [], bool $udp6 = false): SwooleServer
    {
        $default = [
            'host' => '0.0.0.0',
            'port' => 9501,
            'mod' => SWOOLE_PROCESS
        ];
        if (!$this->udpServer) {
            $config = array_merge($default, $config);
            $this->tcpServer = new SwooleServer($config['host'], $config['port'], $config['mod'], $udp6 ? SWOOLE_SOCK_UDP : SWOOLE_SOCK_UDP6);
        }

        return $this->udpServer;
    }
}
