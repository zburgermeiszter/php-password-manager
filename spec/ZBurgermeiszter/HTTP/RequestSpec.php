<?php

namespace spec\ZBurgermeiszter\HTTP;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ZBurgermeiszter\HTTP\Request');
    }
}
