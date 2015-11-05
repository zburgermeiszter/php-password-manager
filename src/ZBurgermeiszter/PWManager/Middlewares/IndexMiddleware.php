<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\HTTP\RedirectResponse;
use ZBurgermeiszter\HTTP\Response;

class IndexMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = [
        '/',
        '/index.php'
    ];

    public function execute(Context $context)
    {
        $response = new RedirectResponse('/static/index.html');
        $context->setResponse($response);
    }

}