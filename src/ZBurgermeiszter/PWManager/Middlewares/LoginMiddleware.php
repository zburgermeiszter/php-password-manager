<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\HTTP\Response;

class LoginMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = '/login';

    public function execute(Context $context)
    {
        $response = new Response("LOGIN");
        $context->setResponse($response);
    }

}