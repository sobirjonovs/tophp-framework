<?php


namespace Bootstrap;

use App\Controllers\Controller;
use Bootstrap\Requests\Request;
use DI\NotFoundException;

class Route extends Controller
{
    private $routes = [];

    private $debugTraces = [];
    /**
     * @var Request
     */
    private $request;

    public function get($url, $controller)
    {
        $this->pushToRoutes($url, $controller);
        $this->pushToDebug();
    }

    private function discoverRoute()
    {
        if ($this->keyExists($this->concretizeUrl(), $this->getRouters('urlsVerbs'))) {
            $this->getRoute();
        } else {
            throw new NotFoundException(sprintf(
                "The requested route <b>%s</b> is not found on server", $this->getRouters('uri'))
            );
        }
    }

    private function getRoute()
    {
        if ($this->checkUriMethod()) {
            $urls = $this->getUrlsVerbs('urls');
            $uriKey = $this->flip($urls, $this->concretizeUrl());
            $data = $this->explode("/", $urls[$uriKey]);
            $this->shift($data);
            $this->dispatch($this->getCallable($uriKey), $data);
        }
    }

    private function checkUriMethod(): bool
    {
        $uri = $this->getRouters('urlsVerbs')[$this->concretizeUrl()];
        $method = $this->getRouters('requestMethod');
        if ($uri == $method) return true;
        else return false;
    }

    private function getCallable(int $key)
    {
        if ($this->keyExists('object', $this->routes[$key]))
            return $this->routes[$key]['object'];

        return [
            $this->routes[$key]['class'],
            $this->routes[$key]['method']
        ];
    }

    private function getFunctionName()
    {
        $workingEnvironment = debug_backtrace();
        $functionParams = $workingEnvironment[2];
        return $functionParams['function'];
    }

    private function pushToRoutes(...$values)
    {
        $router['url'] = $values[0];
        if (is_object($values[1])) {
            $router['object'] = $values[1];
        } else {
            $router['class'] = $values[1][0];
            $router['method'] = $values[1][1];
        }
        $router['verb'] = $this->getFunctionName();
        $this->push($router, $this->routes);
    }

    private function pushToDebug()
    {
        $debug['method'] = $this->getFunctionName();
        $debug['routes'] = array_filter(array_column(debug_backtrace(), 'args'));
        $this->push($debug, $this->debugTraces);
    }

    private function getUrlsVerbs(string $needle = null)
    {
        $data = [
            'urls' => $this->processUrls(array_column($this->routes, 'url'),
                request()->getUri()),
            'verbs' => array_column($this->routes, 'verb')
        ];

        return $needle ? $data[$needle] : $data;
    }

    private function getRouters(string $needle = null)
    {
        $uri = htmlspecialchars(filter_var(ltrim(request()->getUri(), '/'), FILTER_SANITIZE_URL));
        $data = [
            'requestMethod' => strtolower(request()->getMethod()),
            'uri' => $uri,
            'urlsVerbs' => array_combine(
                $this->processUrls($this->getUrlsVerbs('urls'), $uri),
                $this->getUrlsVerbs('verbs')
            )
        ];
        return $needle ? $data[$needle] : $data;
    }

    private function concretizeUrl()
    {
        return empty($this->getRouters('uri')) ? "/" : $this->getRouters('uri');
    }

    // DON'T TOUCH!
    public function __destruct()
    {
        try {
            $this->discoverRoute();
        } catch (NotFoundException $notFoundException) {
            echo $notFoundException->getMessage();
        }
    }
}