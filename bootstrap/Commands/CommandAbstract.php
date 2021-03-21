<?php

namespace Bootstrap\Commands;

abstract class CommandAbstract
{

    public $env;
    /**
     * @var mixed
     */
    private $commands;

    public function __construct()
    {
        $this->commands = includeCommands();
    }

    abstract public function execute();

    public function validateCommand($environmentArgument)
    {
        if (array_key_exists($environmentArgument[1], $this->commands)) {
            return true;
        } else {
            return false;
        }
    }

    protected function hasOption($environmentArgument)
    {
        $difference = array_diff($this->commands[$environmentArgument[1]],
            $this->getOptionValues($environmentArgument));

        if (empty($difference)) return true;
        else return false;
    }

    protected function getOptionValues($environmentArgument)
    {
        return array_slice($environmentArgument, 2);
    }
}