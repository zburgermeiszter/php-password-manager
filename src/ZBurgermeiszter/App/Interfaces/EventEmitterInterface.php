<?php

namespace ZBurgermeiszter\App\Interfaces;

interface EventEmitterInterface
{
    public function emit($eventName, $payload);
    public function on($eventName, \Closure $eventListener);
}