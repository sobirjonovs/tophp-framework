<?php

use Bootstrap\Application;
use Bootstrap\Dotenv;
use Bootstrap\Commands\MigrationCommand;
use Bootstrap\Commands\ServerCommand;
use Bootstrap\Route;
use Bootstrap\View;
use Core\Models\Model;

function dependencyInjector($argv = null)
{
    $builder = new DI\ContainerBuilder();
    $builder->addDefinitions([
        Kernel::class => function($container) use ($argv) {
            return new Kernel($container->get($argv[1]), $container->get('dotenv'));
        },
        'server' => function($container) {
            return new ServerCommand();
        },
        'migrate' => function($container) {
            return new MigrationCommand();
        },
        'dotenv' => function($container) {
            return new Dotenv(__DIR__ . '/../.env');
        },
        'Application' => function($container) {
            return new Application($container->get('dotenv'), $container->get('request'));
        },
        'Router' => function($container) {
            return new Route();
        },
        'Model' => function($container) {
            return new Model();
        },
        'request' => function($container) {
            return new Bootstrap\Requests\Request();
        },
        'View' => function($container) {
            return new View();
        }
    ]);
    $container = $builder->build();

    return $container;
}
