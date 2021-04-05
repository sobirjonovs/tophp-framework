<?php

namespace Bootstrap\Commands;


class ServerCommand extends CommandAbstract
{
    private $ipAddress = "127.0.0.1";
    private $port = "90";
    const ROOT_FOLDER = 'public/';
    const COMMAND = "php -S";

    public function execute()
    {
        $connection = @stream_socket_client(sprintf("%s:%d", $this->ipAddress,$this->port));
        if ($this->isResource($connection))
            exec(sprintf(
                'sudo %s %s:%d -t %s',
                self::COMMAND,
                $this->ipAddress,
                $this->port,
                self::ROOT_FOLDER)
            );
        else
            exec(sprintf(
                '%s %s:%d -t %s',
                self::COMMAND,
                $this->ipAddress,
                $this->port,
                self::ROOT_FOLDER)
            );
    }

    private function isResource($resource)
    {
        if (!is_resource($resource))
            return $this->isSystem('Linux');
        else
            return $this->port++ && $this->execute();
    }

    private function isSystem(string $type)
    {
        return PHP_OS === $type;
    }
}
