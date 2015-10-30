<?php

namespace spec\ZBurgermeiszter\App;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use ZBurgermeiszter\HTTP\Request;
use ZBurgermeiszter\HTTP\Response;

class KernelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('ZBurgermeiszter\App\Kernel');
    }

    function let()
    {
        $this->beConstructedWith(new Request(), new Response());
    }


    /*function it_should_not_be_instantiated_with_invalid__request_and_response()
    {
        $this->beConstructedWith(false, false);
        $this->shouldHaveType('ZBurgermeiszter\App\Kernel');
    }*/
}
