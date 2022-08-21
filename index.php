<?php

use Melon\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\SingleCommandApplication;

require __DIR__ . "/vendor/autoload.php";

(new SingleCommandApplication())
    ->setName("melon-nginx")
    ->setVersion('0.0.1')
    ->setCode(function (InputInterface $input, OutputInterface $output) {

        $app = new Application(__DIR__);
        $app->run();

        return Command::SUCCESS;
    })->run();