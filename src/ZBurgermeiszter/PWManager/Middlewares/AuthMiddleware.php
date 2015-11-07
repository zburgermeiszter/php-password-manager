<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\HTTP\JSONResponse;

class AuthMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $preRoute = [
        '/list'
    ];

    public function execute(Context $context)
    {
        $context->setResponse(JSONResponse::createFinal(
            ['error' => 'Invalid token'],
            401,
            ['WWW-Authenticate' => 'Basic realm="PasswordManager"']
        ));
    }

}