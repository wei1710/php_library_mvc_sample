<?php

/**
 * Front controller
 */

/**
 * It requires all class files instead of loading them one by one
 */
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});

/**
 * Routing
 */
$router = new Core\Router();
$router->add('', [
    'controller' => 'Home',
    'action'     => 'index'
]);

/**
 * Route dispatch
 */
$url = $_SERVER['QUERY_STRING'];
$router->dispatch($url);