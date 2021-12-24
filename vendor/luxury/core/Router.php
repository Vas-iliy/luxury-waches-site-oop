<?php


namespace luxury;


class Router
{
    protected static $routes = [];
    protected static $route = [];

    public static function add($reg, $route = []) {
        self::$routes[$reg] = $route;
    }

    public static function  getRoutes() {
        return self::$routes;
    }

    public static function  getRoute() {
        return self::$route;
    }

    public static function dispatch($url) {
        if (self::matchRoute($url)) {
            echo 'ok';
        }
        else {
            echo 'no';
        }
    }

    public static function matchRoute($url) {
        return true;
    }
}