<?php

namespace ZBurgermeiszter\App\Abstracts;

use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\App\Interfaces\RouteControllerMiddlewareInterface;
use ZBurgermeiszter\HTTP\JSONResponse;


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

    public function execute(Context $context)
    {
        $httpMethodFunctionPrefix = 'http';

        $requestMethod = strtoupper($context->getRequest()->getMethod());

        if (!method_exists($this, $httpMethodFunctionPrefix . $requestMethod)) {
            return $context->setResponse(JSONResponse::createFinal([
                'error' => 'Unhandled request method: ' . $requestMethod
            ], 404));
        }

        return $this->{$httpMethodFunctionPrefix . $requestMethod}($context);
    }
}