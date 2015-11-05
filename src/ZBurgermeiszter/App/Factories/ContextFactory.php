<?php

namespace ZBurgermeiszter\App\Factories;

use ZBurgermeiszter\App\Context;
use ZBurgermeiszter\App\Services\ConfigurationService;
use ZBurgermeiszter\App\Services\ServiceRepository;
use ZBurgermeiszter\HTTP\Request;
use ZBurgermeiszter\HTTP\Response;

class ContextFactory
{

    public static function create()
    {
        $request = Request::createFromGlobals();
        $response = new Response();
        $serviceRepository = new ServiceRepository();


        $configPath = getcwd() . "/../app/config.json";
        $configService = new ConfigurationService($configPath);


        $serviceRepository->registerService('config', $configService);


        return new Context($request, $response, $serviceRepository);

    }
}