<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\HTTP\Response;

class AuthMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $preRoute = [
        '/login'
        //, '/index.php'
    ];

    public function execute(Context $context)
    {
        die("AUTH");
        $response = new Response("AUTH NEEDED");
        $context->setResponse($response);
    }

}