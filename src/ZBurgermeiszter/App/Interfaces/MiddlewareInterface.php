<?php

namespace ZBurgermeiszter\App\Interfaces;

use ZBurgermeiszter\App\Context;

interface MiddlewareInterface
{
    public function execute(Context $context);
}