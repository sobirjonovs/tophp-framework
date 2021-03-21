<?php

namespace Bootstrap\Commands;


class MigrationCommand extends CommandAbstract
{
    public function execute()
    {
        if ($this->hasOption($this->env)) {
            $options = current($this->getOptionValues($this->env));
            if ($options === "--table") {
                echo "\e[32mMigration was created successfully";
            }
        }
    }
}
