<?php

namespace ZBurgermeiszter\App\Traits;

trait RouteControllerMiddlewareTrait
{
    protected static $route = '#';

    public static function getRoute()
    {
        return static::$route;
    }
}