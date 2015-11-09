<?php

namespace ZBurgermeiszter\PWManager\Middlewares;

use ZBurgermeiszter\App\Abstracts\AbstractRouteControllerMiddleware;
use ZBurgermeiszter\HTTP\JSONResponse;

class CredentialsViewUpdateDeleteAPIMiddleware extends AbstractRouteControllerMiddleware
{
    protected static $route = [
        '/\/credentials\/(\d+)/'
    ];

    protected function httpGET()
    {
        $this->context->setResponse(JSONResponse::createFinal($this->getRouteMatches(), 200));
    }

}