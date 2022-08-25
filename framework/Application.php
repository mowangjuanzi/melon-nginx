<?php

namespace Melon;

use Symfony\Component\Yaml\Yaml;

class Application
{
    /**
     * @var array
     */
    protected array $workers = [];

    /**
     * @var array
     */
    public array $config = [];

    /**
     * 构造函数
     *
     * @param string $app
     */
    public function __construct(protected readonly string $app)
    {
        $this->reloadConfig();
    }

    /*
     * 分叉子进程
     */
    protected function fork()
    {
        $daemon = $this->config['daemon'] ?? 'on';

//        if ($daemon == 'on') {
//            $pid = pcntl_fork();
//
//            if ($pid == -1) {
//                dd("fork worker process failed");
//            } elseif ($pid) {
//                $this->workers[] = $pid;
//            } else {
        $worker = new Worker($this);
        $worker->run();
//            }
//        }
    }

    /**
     * 运行
     *
     * @return void
     */
    public function run(): void
    {
        $this->fork();
    }

    /**
     * 获取配置
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * 检查配置 重载配置
     *
     * @return void
     */
    public function reloadConfig(): void
    {
        $config = Yaml::parseFile($this->app . "/config/melon.yaml");

        $status = $this->configCheck($config);

        if ($status) {
            $this->config = $config;
        }
    }

    /**
     * 配置校验
     */
    protected function configCheck(array $config): bool
    {
        return true;
    }
}