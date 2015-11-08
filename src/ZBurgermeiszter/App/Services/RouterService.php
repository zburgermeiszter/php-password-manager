<?php

namespace ZBurgermeiszter\App\Services;

use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\App\Interfaces\MiddlewareInterface;
use ZBurgermeiszter\App\Interfaces\RouteControllerMiddlewareInterface;
use ZBurgermeiszter\HTTP\JSONResponse;

class RouterService
{
    private $routes = [];

    private $preRoutes = [];

    public function routeRequest(Context $context)
    {
        $preRouteController = $this->getPreRouteController($context);
        $this->executeController($context, $preRouteController);

        // If the response has been set to final state in the pre-routing, do not run the route controller.
        if ($context->getResponse()->isFinal()) return;

        $controller = $this->getRouteController($context);
        $this->executeController($context, $controller);
    }

    public function registerRouteMiddlewareController(RouteControllerMiddlewareInterface $middleware)
    {
        $routes = $middleware::getRoute();
        $routeTypeName = "routes";

        if ($routes === null) {
            $routes = $middleware::getPreRoute();
            $routeTypeName = "preRoutes";
        }

        $routeConfigType = gettype($routes);
        switch ($routeConfigType) {
            case 'string':
                $this->{$routeTypeName}[$routes] = $middleware;
                break;
            case 'array':
                foreach ($routes as $route) {
                    $this->{$routeTypeName}[$route] = $middleware;
                }
                break;
            default:
                throw new \Exception("Invalid route configuration format: $routeConfigType");

        }

    }

    private function getPreRouteController(Context $context)
    {
        $requestRoute = $context->getRequestRoute();
        $routeMatcher = $this->routeMatcherFactory($requestRoute);

        foreach ($this->preRoutes as $route => $routeController) {
            $isRouteMatch = $routeMatcher($route);
            if ($isRouteMatch) {
                return $routeController;
            }
        }

        return false;
    }

    private function executeController(Context $context, $controller)
    {
        switch (true) {
            case $controller instanceof MiddlewareInterface:
                $controller->execute($context);
                break;
            case $controller instanceof \Closure:
                $controller($context);
                break;
            //default:
            //throw new \Exception("Invalid route controller type: " . get_class($controller));
        }
        return false;
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

        foreach ($this->routes as $route => $routeController) {
            $isRouteMatch = $routeMatcher($route);
            if ($isRouteMatch) {
                return $routeController;
            }
        }

        $context->setResponse(JSONResponse::createFinal([
            'error' => "Route not found: $requestRoute"
        ], 404));
        return false;
    }

    /**
     * @param $requestRoute
     * @return \Closure
     */
    private function routeMatcherFactory($requestRoute)
    {
        return function ($routePattern) use ($requestRoute) {

            set_error_handler(function () {
            }, E_WARNING);
            $isRegex = (@preg_match($routePattern, $requestRoute, $matches) !== false);
            restore_error_handler();

            if ($isRegex) {
                return (bool)$matches;
            } else {
                return ($routePattern === $requestRoute);
            }
        };
    }

}