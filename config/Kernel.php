<?php

use Bootstrap\Commands\CommandAbstract;
use Bootstrap\Dotenv;
use Bootstrap\Commands\MigrationCommand;
use Bootstrap\Commands\ServerCommand;

class Kernel
{
    private $environmentArgument;
    /**
     * @var Dotenv
     */
    private $dotenv;
    /**
     * @var CommandAbstract
     */
    private $commandAbstract;

    public function __construct(CommandAbstract $commandAbstract, Dotenv $dotenv)
    {
        $this->commandAbstract = $commandAbstract;
        $this->dotenv = $dotenv;
    }

    public function load()
    {
        $this->execute();
        $this->dotenv->load();
    }

    public function execute()
    {
        $this->commandAbstract->env = $this->environmentArgument;
        if ($this->commandAbstract->validateCommand($this->environmentArgument)) {
            $this->commandAbstract->execute();
        }
    }

    public function setArgument(array $arg)
    {
        $this->environmentArgument = $arg;
    }
}