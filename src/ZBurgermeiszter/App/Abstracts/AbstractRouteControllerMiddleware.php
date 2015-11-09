<?php

namespace ZBurgermeiszter\App\Abstracts;

use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\App\Interfaces\RouteControllerMiddlewareInterface;
use ZBurgermeiszter\HTTP\JSONResponse;


abstract class AbstractRouteControllerMiddleware implements RouteControllerMiddlewareInterface
{
    protected static $preRoute = null;
    protected static $route = null;

    /**
     * @var Context
     */
    protected  $context;

    public static function getPreRoute()
    {
        return static::$preRoute;
    }

    public static function getRoute()
    {
        return static::$route;
    }

    final public function execute(Context $context)
    {
        $httpMethodFunctionPrefix = 'http';

        $requestMethod = strtoupper($context->getRequest()->getMethod());

        $specificHTTPMethodHandlerExists = method_exists($this, $httpMethodFunctionPrefix . $requestMethod);
        $generalHTTPMethodHandlerExists = method_exists($this, $httpMethodFunctionPrefix);

        if (!$specificHTTPMethodHandlerExists && !$generalHTTPMethodHandlerExists) {
            return $context->setResponse(JSONResponse::createFinal([
                'error' => 'Unhandled request method: ' . $requestMethod
            ], 404));
        }

        $this->context = $context;

        $requestMethod = ($specificHTTPMethodHandlerExists)?$requestMethod:"";

        return $this->{$httpMethodFunctionPrefix . $requestMethod}();
    }

    final protected function getRouteMatches()
    {
        $requestRoute = $this->context->getRequestRoute();

        $currentRoute = $this->context->getRouter()->getCurrentRoute();

        set_error_handler(function () {}, E_WARNING);
        $isRegex = (@preg_match($currentRoute, $requestRoute, $matches) !== false);
        restore_error_handler();

        array_shift($matches); // drop the route from matches

        return ($isRegex)?$matches:[];
    }
}