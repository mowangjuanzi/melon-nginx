<?php

namespace Melon;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Yaml\Yaml;

class Application
{
    protected readonly array $config;

    public function __construct(protected string $app)
    {
        $this->config = Yaml::parseFile($this->app . "/config/melon.yaml");
    }

    /*
     * 分叉子进程
     */
    protected function fork()
    {
        $daemon = $this->config['daemon'] ?? 'on';

        if ($daemon == 'on') {
            $pid = pcntl_fork();

            if ($pid == -1) {
                dd("fork worker process failed");
            } elseif ($pid) {
                pcntl_wait($status);
            } else {
                $worker = new Worker();
            }
        }
    }

    #[NoReturn]
    public function run(): void
    {
        $this->fork();
    }
}