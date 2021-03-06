<?php

namespace ZBurgermeiszter\App\Factories;

use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\App\Kernel;

class KernelFactory
{
    public static function create(Context $context)
    {
        $kernel = new Kernel();

        $router = $context->getRouter();

        $kernel->on('request', function () use ($context, $router) {
            $router->routeRequest($context);
        });

        $kernel->registerAfterAll(function() use ($context){
            echo $context->getResponse();
        });

        return $kernel;
    }
}