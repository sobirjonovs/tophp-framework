<?php


namespace Bootstrap;

use Bootstrap\Helpers\ArrayHelper;

class UrlManager
{

    use ArrayHelper;

    protected function processUrls(array $routes, $requestUri)
    {
        return array_map(function($value) use ($requestUri) {
            $wildcard = explode("/", $value);
            $requests = explode("/", ltrim($requestUri, "/"));
            if (count($wildcard) > 1) $this->shift($wildcard);
            if (count($requests) > 1) $this->shift($requests);
            $this->delimit($wildcard, "/");
            return preg_replace($wildcard, $requests, $value);
        }, $routes);
    }

    protected function is($route): bool
    {
        if (trim($route) === basename(request()->getUri())) return true;
        else return false;
    }
}