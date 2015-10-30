<?php

namespace spec\ZBurgermeiszter\App\Middleware;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MiddlewareInterfaceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ZBurgermeiszter\App\Middleware\MiddlewareInterface');
    }
}
