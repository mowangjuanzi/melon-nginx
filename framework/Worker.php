<?php

namespace Melon;

class Worker
{
    protected array $ports;

    protected array $sockets;

    public function __construct(protected readonly Application $application)
    {
        // 获取配置
        $config = $this->application->getConfig();

        // 获取需要实例化的端口
        $this->getPorts($config);

        $eventConfig = new \EventConfig();

        $eventBase = new \EventBase($eventConfig);

        $event = new \Event($eventBase, array_shift($this->sockets), \Event::SIGNAL | \Event::READ);
    }

    /**
     * 格式化配置，通过端口来映射配置
     */
    protected function getPorts(array $config): void
    {
        $this->ports = [];
        foreach ($config['http']['server'] as $http) {
            $this->ports[$http['listen']][] = $http;
        }
    }

    protected function run()
    {
        // TODO 挖个坑，这里要支持一个 Worker 绑定多个 socket
        foreach ($this->ports as $port => $tmp) {
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            socket_bind($socket, '0.0.0.0', $port);
//            socket_set_option($socket, SOL_SOCKET, SO_REUSEPORT, 1); // reuseport

            $this->sockets[$port] = $socket;


        }
    }
}