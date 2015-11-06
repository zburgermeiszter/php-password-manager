<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\HTTP\Response;

class ListPasswordsMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = [
        '/list'
    ];

    public function execute(Context $context)
    {
        die("LIIIIST");
        $context->setResponse(new Response("LIST"));
    }

}