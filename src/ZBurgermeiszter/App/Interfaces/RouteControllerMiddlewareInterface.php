<?php

namespace ZBurgermeiszter\App\Interfaces;

interface RouteControllerMiddlewareInterface extends MiddlewareInterface
{
    public static function getRoute();
}