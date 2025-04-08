<?php

namespace Core;

class Router
{
    protected array $routes = [];
    protected array $params = [];

    public function __get(string $property): array|false
    {
        switch ($property) {
            case 'routes':
            case 'params':
                return $this->$property;
            default:
                return false;
        }
    }

    public function add(string $route, array $params): void
    {
        $this->routes[$route] = $params;
    }

    public function match(string $url): bool
    {
        // If the URL ends in an ID, it is extracted
        $parts = explode('/', $url);
        $lastPart = end($parts);
        if (is_numeric($lastPart)) {
            $id = $lastPart;
            $url = substr($url, 0, strlen($url) - (strlen($lastPart) + 1));
        } else {
            $id = 0;
        }

        // The URL is searched in the routing table
        if (array_key_exists($url, $this->routes)) {
            $this->params = $this->routes[$url];
            if ($id !== 0) {
                $this->params['id'] = $id;
            }
            return true;
        }
        return false;
    }

    /**
     * Calls the controller corresponding to the URL it receives
     */
    public function dispatch(string $url): bool|string
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = "App\Controllers\\$controller";

            if (class_exists($controller)) {
                $controllerInstance = new $controller($this->params);
                $action = $this->params['action'];

                if (is_callable([$controllerInstance, $action])) {
                    $controllerInstance->$action();
                    return true;
                } else {
                    throw new \Exception("Method $action in controller $controller not found");
                }
            } else {
                throw new \Exception("Controller class $controller not found");
            }
        } else {
            throw new \Exception("URL $url not found", 404);
        }
    }

    protected function removeQueryStringVariables(string $url): string
    {
        // Notice that PHP replaces "?" by "&"
        // when it receives the URL via $_SERVER['QUERY_STRING']
        $parts = explode('&', $url, 2);
        $url = strpos($parts[0], '=') ? '' : $parts[0];
        return $url;
    }
}