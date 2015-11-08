<?php

namespace ZBurgermeiszter\App\Interfaces;

use ZBurgermeiszter\App\Context;

interface RouteControllerMiddlewareInterface extends MiddlewareInterface
{
    public static function getPreRoute();
    public static function getRoute();

    public function execute(Context $context);
}