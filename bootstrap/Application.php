<?php

namespace Bootstrap;


use Bootstrap\Requests\Request;

class Application
{
    /**
     * @var Dotenv
     */
    private $dotenv;
    /**
     * @var \DI\Container|string
     */
    private $container;
    /**
     * @var Request
     */
    private $request;

    public function __construct(Dotenv $dotenv, Request $request)
    {
        $this->dotenv = $dotenv;
        $this->request = $request;
        $this->container = dependencyInjector();
    }

    public function load()
    {
        $this->dotenv->load();
        $this->loadRoutes();
    }

    private function loadRoutes()
    {
        $route = $this->container->get('Router');
        require_once __DIR__ . '/../routes/web.php';
    }
}