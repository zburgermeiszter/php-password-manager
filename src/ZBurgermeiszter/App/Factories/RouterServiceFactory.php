<?php

namespace ZBurgermeiszter\App\Factories;

use ZBurgermeiszter\App\Interfaces\RouteControllerMiddlewareInterface;
use ZBurgermeiszter\App\Services\RouterService;

class RouterServiceFactory
{
    public static function create()
    {
        $router = new RouterService();

        static::autoloadMiddlewares($router);

        return $router;
    }

    private static function autoloadMiddlewares(RouterService $router)
    {
        /**
         * @var $controller RouteControllerMiddlewareInterface
         */
        $projectRoot = dirname(getcwd()) . '/src/';
        $namespaceRoot = dirname(dirname(str_replace('\\', '/', __NAMESPACE__)));
        $namespaceSuffix = '/*/Middlewares';
        $middlewareFiles = glob($projectRoot . $namespaceRoot . $namespaceSuffix . '/*');

        foreach ($middlewareFiles as $file) {

            $className = str_replace('/', '\\', dirname(str_replace($projectRoot, '', $file)) . '/' . pathinfo($file, PATHINFO_FILENAME));
            require_once($file);
            $controller = new $className;
            $router->registerRouteMiddlewareController($controller);
        }
    }
}