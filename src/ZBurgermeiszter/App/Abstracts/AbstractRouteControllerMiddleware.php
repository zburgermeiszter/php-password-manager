<?php

namespace ZBurgermeiszter\App\Abstracts;

use ZBurgermeiszter\App\Interfaces\RouteControllerMiddlewareInterface;


abstract class AbstractRouteControllerMiddleware implements RouteControllerMiddlewareInterface
{
    protected  static $preRoute = null;
    protected static $route = null;

    public static function getPreRoute()
    {
        return static::$preRoute;
    }

    public static function getRoute()
    {
        return static::$route;
    }
}