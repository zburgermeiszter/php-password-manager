<?php

namespace spec\ZBurgermeiszter\HTTP;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ZBurgermeiszter\HTTP\Response');
    }
}
