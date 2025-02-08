<?php

namespace App\Config;

use Bramus\Router\Router;

class Route
{
    private static $router;

    public static function init()
    {
        self::$router = new Router();
    }

    public static function get($route, $handler)
    {
        self::$router->get($route, function () use ($handler) {
            self::invoke($handler, func_get_args());
        });
    }

    public static function post($route, $handler)
    {
        self::$router->post($route, function () use ($handler) {
            self::invoke($handler, func_get_args());
        });
    }

    public static function put($route, $handler)
    {
        self::$router->put($route, function () use ($handler) {
            self::invoke($handler, func_get_args());
        });
    }

    public static function delete($route, $handler)
    {
        self::$router->delete($route, function () use ($handler) {
            self::invoke($handler, func_get_args());
        });
    }

    public static function run()
    {
        self::$router->run();
    }

    protected static function invoke($fn, $matches = null)
    {
        if (is_array($fn)) {
            $controller = new $fn[0]();
            $method = $fn[1];
            return call_user_func_array([$controller, $method], $matches);
        }

        return call_user_func_array($fn, $matches);
    }
}
