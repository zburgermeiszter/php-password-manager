<?php

namespace ZBurgermeiszter\App;

use ZBurgermeiszter\HTTP\Request;
use ZBurgermeiszter\HTTP\Response;

class Kernel
{
    public function __construct(Request $request, Response $response)
    {
        if( ! ($request instanceof Request && $response instanceof Response)) {
            throw new \InvalidArgumentException(
                'Kernel arguments should be ZBurgermeiszter\HTTP\Request and ZBurgermeiszter\HTTP\Response.' .
                'Got: ' . get_class($request) . ' and ' . get_class($response)
            );
        }
    }
}
