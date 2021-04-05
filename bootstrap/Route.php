<?php


namespace Bootstrap;

use App\Controllers\Controller;
use Bootstrap\Requests\Request;
use DI\NotFoundException;

class Route extends Controller
{
    /**
     * @var
     */
    private $route;

    /**
     * @param $url
     * @param $controller
     */
    public function get($url, $controller)
    {
        if (preg_match($this->routePattern($url), $this->getUri(), $data)) {
            $this->route = $this->getData($data);
            $this->route['controller'] = $controller;
        }
    }

    /**
     * @throws NotFoundException
     */
    private function discoverRoute()
    {
        if (empty($this->route)) throw new NotFoundException(sprintf(
                "The requested route <b>%s</b> is not found on server", $this->getUri())
        );

        $this->dispatch($this->route['controller'], $this->route);
    }

    /**
     * @param $url
     * @return string
     */
    private function routePattern($url): string
    {
        return "#^/?" . preg_replace("#/{([^/]+)}#", "/(?<$1>[^/]+)", $url) . "/?$#";
    }

    /**
     * @param array $data
     * @return array
     */
    private function getData(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (!is_int($key)) $result[$key] = $value;
        }
        return$result;
    }

    public function __destruct()
    {
        try {
            $this->discoverRoute();
        } catch (NotFoundException $notFoundException) {
            echo $notFoundException->getMessage();
        }
    }
}