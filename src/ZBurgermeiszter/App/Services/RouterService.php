<?php

namespace ZBurgermeiszter\App\Services;

use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\App\Interfaces\MiddlewareInterface;
use ZBurgermeiszter\App\Interfaces\RouteControllerMiddlewareInterface;

class RouterService
{
    private $routes = [];

    public function routeRequest(Context $context)
    {
        $controller = $this->getRouteController($context);
        switch(true) {
            case $controller instanceof MiddlewareInterface:
                $controller->execute($context);
                break;
            case $controller instanceof \Closure:
                $controller($context);
                break;
            default:
                throw new \Exception("Invalid route controller type: " . get_class($controller));
        }
    }

    public function registerRouteMiddlewareController(RouteControllerMiddlewareInterface $middleware)
    {
        $routes = $middleware::getRoute();
        $routeConfigType = gettype($routes);
        switch($routeConfigType){
            case 'string':
                $this->routes[$routes] = $middleware;
                break;
            case 'array':
                foreach($routes as $route) {
                    $this->routes[$route] = $middleware;
                }
                break;
            default:
                throw new \Exception("Invalid route configuration format: $routeConfigType");

        }

    }

    /**
     * @param Context $context
     * @return MiddlewareInterface|\Closure
     * @throws \Exception
     */
    private function getRouteController(Context $context)
    {
        $requestRoute = $context->getRequestRoute();
        $routeMatcher = $this->routeMatcherFactory($requestRoute);

        foreach($this->routes as $route => $routeController) {
            $isRouteMatch = $routeMatcher($route);
            if($isRouteMatch) {
                return $routeController;
            }
        }

        throw new \Exception("No route found: $requestRoute");
    }

    /**
     * @param $requestRoute
     * @return \Closure
     */
    private function routeMatcherFactory($requestRoute)
    {
        return function ($routePattern) use($requestRoute) {

            set_error_handler(function() {}, E_WARNING);
            $isRegex = (@preg_match($routePattern, $requestRoute, $matches) !== false);
            restore_error_handler();

            if($isRegex) {
                return (bool)$matches;
            } else {
                return ($routePattern === $requestRoute);
            }
        };
    }

}