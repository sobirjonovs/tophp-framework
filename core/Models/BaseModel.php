<?php

namespace Core\Models;

use Core\DatabaseInterface;
use Exception;
use PDO;
use PDOException;
use ReflectionClass;

abstract class BaseModel extends PDO implements DatabaseInterface
{
    /*
     * Database configurations
     * */
    private const DRIVER = 'DB_DRIVER';
    private const HOST = 'DB_HOST';
    private const USER = 'DB_USERNAME';
    private const PASSWORD = 'DB_PASSWORD';
    private const DATABASE = 'DB_DATABASE';

    /*
     * Class
     * */
    public $called_class;
    /**
     * @var ReflectionClass
     */
    public $reflection;

    /**
     * BaseModel constructor.
     * @param ReflectionClass|null $reflectionClass
     */
    public function __construct()
    {
        try {
            parent::__construct(...$this->getCredentials());
        } catch (PDOException $PDOException) {
            die($PDOException->getMessage());
        }
    }

    /**
     * @return array|false|string
     */
    private function getCredentials()
    {
        return [
            // DSN
            getenv(self::DRIVER) . ':host=' . getenv(self::HOST) .
            ";dbname=" . getenv(self::DATABASE),
            // Database username
            getenv(self::USER),
            // DB User's password
            getenv(self::PASSWORD),
            $this->options()
        ];
    }

    /**
     * @return array
     */
    private function options(): array
    {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];
    }

    /**
     * @param bool $returnObject
     * @return string|object
     */
    public function getCalledClass($returnObject = false)
    {
        return $returnObject ? (new $this->called_class) : $this->called_class;
    }

    /**
     * @param $reflection
     */
    public function setReflection($reflection)
    {
        $this->reflection = new ReflectionClass($reflection);
    }

    /**
     * @param $className
     */
    public function setCalledClass($className)
    {
        $this->called_class = $className;
    }

    /**
     * @return string|array
     */
    public function tableName()
    {
        if ($this->reflection->hasProperty('table')) {
            $property = $this->reflection->getProperty('table');
            $property->setAccessible(true);
            return $property->getValue($this->getCalledClass(true));
        }
        return $this->addSuffix($this->getCalledClass());
    }

    /**
     * @param string $table
     * @param string $suffix
     * @return string
     */
    private function addSuffix(string $table, $suffix = 's'): string
    {
        $table = strtolower(substr(strrchr($table, "\\"), 1));
        if (str_ends_with('s', $table)) return $table;
        return $table . $suffix;
    }

    /**
     * @param array $params
     * @param string $escapeSequence
     * @return string
     */
    public function tables(array $params, $escapeSequence = "`"): string
    {
        $tables = implode("{$escapeSequence},{$escapeSequence}", array_keys($params));
        return sprintf("{$escapeSequence}%s{$escapeSequence}", $tables);
    }

    /**
     * @param array $params
     * @param false $returnCount
     * @return array|int
     */
    public function values(array $params, $returnCount = false)
    {
        $values = array_values($params);
        if ($returnCount) return count($values);
        return $values;
    }

    public function createSqlQuery(array $params, string $type = "insert")
    {
        $placeholders = rtrim(
            str_repeat('?,',
                $this->values($params, true)
            ), ','
        );

        if ($type === "insert") {
            return "INSERT INTO {$this->tableName()} ({$this->tables($params)}) 
                    VALUES ({$placeholders});";
        }
        if ($type === "where" && !empty($params)) {
            return "SELECT * FROM {$this->tableName()} WHERE {$this->multipleCondition($params)}";
        }

        if ($type === "all") {
            return "SELECT * FROM {$this->tableName()}";
        }

        if ($type === 'delete') {
            return "DELETE FROM {$this->tableName()} WHERE {$this->multipleCondition($params)}";
        }
    }

    public function placeholderize(array $parameters)
    {
        $result = [];
        $tableAndValues = array_map(function($key, $value) {
            return [":$key" => $value];
        }, array_keys($parameters), $parameters);
        foreach ($tableAndValues as $value) {
            $result[array_key_first($value)] = current($value);
        }
        return $result;
    }

    public function multipleCondition(array $params)
    {
        $clause = "";
        $i = 1;
        foreach ($params as $column => $condition) {
            if (count($params) === 1) {
                $clause .= " `$column` = :$column";
                break;
            }
            if (count($params) === $i)
                $clause .= " `$column` = :$column";
            else
                $clause .= " `$column` = :$column AND";
            $i++;
        }
        return $clause;
    }
}