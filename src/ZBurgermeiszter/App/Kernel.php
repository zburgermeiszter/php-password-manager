<?php

namespace ZBurgermeiszter\App;

use ZBurgermeiszter\App\Interfaces\EventEmitterInterface;
use ZBurgermeiszter\App\Traits\EventEmitterTrait;

class Kernel implements EventEmitterInterface
{
    use EventEmitterTrait;
}
