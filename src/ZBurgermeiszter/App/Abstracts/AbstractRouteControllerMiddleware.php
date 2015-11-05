<?php

namespace ZBurgermeiszter\App\Abstracts;

use ZBurgermeiszter\App\Interfaces\RouteControllerMiddlewareInterface;


abstract class AbstractRouteControllerMiddleware implements RouteControllerMiddlewareInterface
{
    protected static $route = '#';

    public static function getRoute()
    {
        return static::$route;
    }
}