<?php

namespace ZBurgermeiszter\App\Factories;

use ZBurgermeiszter\App\Services\ConfigurationService;
use ZBurgermeiszter\App\Services\ServiceRepository;

class ServiceRepositoryFactory
{
    public static function create()
    {

        $serviceRepository = new ServiceRepository();

        $configService = ConfigurationService::create(getcwd() . "/../app/config.json");
        $databaseConfig = $configService->get('database');

        $serviceRepository->registerService('config', $configService);
        $serviceRepository->registerService('router', RouterServiceFactory::create());
        $serviceRepository->registerService('database', DatabaseServiceFactory::create($databaseConfig));

        return $serviceRepository;

    }
}