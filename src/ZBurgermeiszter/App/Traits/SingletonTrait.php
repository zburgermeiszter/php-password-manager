<?php

namespace ZBurgermeiszter\App\Traits;

trait SingletonTrait
{
    private static $instance;

    protected function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;

    }
}