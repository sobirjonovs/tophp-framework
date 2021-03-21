<?php

namespace Bootstrap;

use RuntimeException;

class Dotenv
{
    /**
     * @var string
     */
    private $file_path;

    public function __construct($file)
    {
        $this->file_path = $file;
    }

    public function load()
    {
        try {
            $this->putToEnv($this->getReadableFile($this->file_path));
        } catch (RuntimeException $runtimeException) {
            echo $runtimeException->getMessage();
        }
    }

    private function getReadableFile($file): array
    {
        if (!is_readable($file))
            throw new RuntimeException(sprintf("%s file is not readable", $file));

        $envs = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        return $envs;
    }

    private function putToEnv(array $envs)
    {
        foreach ($envs as $env) {
            list($name, $value) = explode("=", $env);
            $name = trim($name);
            $value = trim($value);
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf("%s=%s", $name, $value));
                $_SERVER[$name] = $value;
                $_ENV[$name] = $value;
            }
        }
    }
}