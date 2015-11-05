<?php

namespace ZBurgermeiszter\App\Factories;

use ZBurgermeiszter\App\Kernel;

class KernelFactory
{
    public static function create()
    {
        $kernel = new Kernel();

        $kernel->on('request', function ($payload) {
            var_dump($payload);
            echo __FILE__;
        });

        return $kernel;
    }
}