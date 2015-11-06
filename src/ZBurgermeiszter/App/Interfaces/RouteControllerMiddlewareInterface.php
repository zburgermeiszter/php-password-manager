<?php

namespace ZBurgermeiszter\App\Interfaces;

interface RouteControllerMiddlewareInterface extends MiddlewareInterface
{
    public static function getPreRoute();
    public static function getRoute();
}