<?php

namespace App\Models;

use Core\Exceptions\UnresolveableMethodException;

class Model
{
    /**
     * @return mixed
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function model()
    {
        return dependencyInjector()->get('Model');
    }

    /**
     * @param $methodName
     * @param $parameters
     * @return mixed
     * @throws UnresolveableMethodException
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function __callStatic($methodName, $parameters)
    {
        $baseModel = static::model();
        $baseModel->setReflection(get_called_class());
        $baseModel->setCalledClass(get_called_class());

        if (count($parameters) > 1)
            throw new UnresolveableMethodException(
                sprintf("1 argument expected but %d passed", count($parameters))
            );

        if (method_exists($baseModel, $methodName))
            return $baseModel->$methodName($parameters[0]);

        throw new UnresolveableMethodException(
            sprintf("%s method is not found", $methodName)
        );
    }
}