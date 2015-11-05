<?php

namespace ZBurgermeiszter\App;

use ZBurgermeiszter\App\Traits\ExceptionAwareEventEmitterTrait;
use ZBurgermeiszter\HTTP\Response;

class App
{
    use ExceptionAwareEventEmitterTrait;

    public function __construct()
    {
        set_error_handler(function($errno, $errstr, $errfile, $errline){
            $this->emit('exception', new \Exception("PHP ERROR: " . $errno . " " . $errstr . " In file: " . $errfile . " on line " . $errline));
        });

        $this->on('exception', function ($e) {
            $this->exceptionHandler($e);
        });

        $this->on('request', function () {
            $context = \ZBurgermeiszter\App\Factories\ContextFactory::create();
            $kernel = \ZBurgermeiszter\App\Factories\KernelFactory::create($context);

            $kernel->emit('request', $context);
        });
    }

    private function exceptionHandler(\Exception $e)
    {
        echo new Response("Unhandled Exception: " . $e->getMessage(), 500);
        die();
    }
}
