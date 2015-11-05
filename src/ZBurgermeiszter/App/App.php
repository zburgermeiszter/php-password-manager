<?php

namespace ZBurgermeiszter\App;

use ZBurgermeiszter\App\Traits\ExceptionAwareEventEmitterTrait;
use ZBurgermeiszter\HTTP\Response;

class App
{
    use ExceptionAwareEventEmitterTrait;

    public function __construct()
    {
        $this->on('error', function ($e) {
            $this->errorHandler($e);
        });

        $this->on('request', function () {
            $this->run();
        });
    }

    private function run()
    {
        $context = \ZBurgermeiszter\App\Factories\ContextFactory::create();
        $kernel = \ZBurgermeiszter\App\Factories\KernelFactory::create();


        $kernel->emit('request', $context);
    }

    private function errorHandler(\Exception $e)
    {
        echo new Response("Unhandled Exception: " . $e->getMessage(), 500);
        die();
    }
}
