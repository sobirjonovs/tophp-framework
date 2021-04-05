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
        if (preg_match($this->pattern($url), $this->getUri(), $data)) {
            $this->set($controller, $this->wildcards($data));
        }
    }

    /**
     * @throws NotFoundException
     */
    private function discoverRoute()
    {
        if (!$this->route) throw new NotFoundException(sprintf(
                "The requested route <b>%s</b> is not found on server", $this->getUri())
        );
        $this->dispatch($this->route['controller'], $this->route);
    }

    /**
     * @param $url
     * @return string
     */
    private function pattern($url): string
    {
        return "#^/?" . preg_replace("#/{([^/]+)}#", "/(?<$1>[^/]+)", $url) . "/?$#";
    }

    /**
     * @param array $data
     * @return array
     */
    private function wildcards(array $data): array
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (!is_int($key)) $result[$key] = $value;
        }
        return $result;
    }

    private function set($controller, $data)
    {
        $this->route = $data;
        $this->route['controller'] = $controller;
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