<?php

namespace ZBurgermeiszter\App\Middleware;

use ZBurgermeiszter\HTTP\Request;
use ZBurgermeiszter\HTTP\Response;

interface MiddlewareInterface
{
    public function __construct(Request $request, Response $response);
}
