<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\HTTP\RedirectResponse;

class IndexMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = [
        '/',
        '/index.php'
    ];

    protected function http()
    {
        $response = new RedirectResponse('/static/index.html');
        $this->context->setResponse($response);
    }

}