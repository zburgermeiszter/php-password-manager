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

    function it_should_be_created_by_injecting_data()
    {
        //create($uri, $method = 'GET', $parameters = array(), $cookies = array(), $files = array(), $server = array(), $content = null)
        //$this->create()
    }
}
