<?php

/**
 * Base controller
 */

namespace Core;

abstract class Controller
{
    protected array $routeParams = [];

    public function __construct(array $routeParams)
    {
        $this->routeParams = $routeParams;
    }

    public function __call(string $name, array $args)
    {
        $method = "{$name}Action";

        if (method_exists($this, $method)) {
            call_user_func_array([$this, $method], $args);
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }
}