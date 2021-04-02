<?php

namespace Bootstrap;


use Bootstrap\Requests\Request;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;

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

    /**
     * Application constructor.
     * @param Dotenv $dotenv
     * @param Request $request
     */
    public function __construct(Dotenv $dotenv, Request $request)
    {
        $this->dotenv = $dotenv;
        $this->request = $request;
        $this->container = dependencyInjector();
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function load()
    {
        try {
            $this->dotenv->load();
            $this->container->get('Model');
            $this->routes();
        } catch (NotFoundException $notFoundException) {
            die($notFoundException->getMessage());
        } catch (DependencyException $dependencyException) {
            die($dependencyException->getMessage());
        }
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    private function routes()
    {
        $route = $this->container->get('Router');
        require_once __DIR__ . '/../routes/web.php';
    }
}