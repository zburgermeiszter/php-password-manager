<?php

namespace ZBurgermeiszter\App\Factories;

use ZBurgermeiszter\App\Services\ConfigurationService;
use ZBurgermeiszter\App\Services\DatabaseRepositoryLoaderService;
use ZBurgermeiszter\App\Services\ServiceRepository;
use ZBurgermeiszter\App\Services\SessionService;

class ServiceRepositoryFactory
{
    public static function create()
    {

        $serviceRepository = new ServiceRepository();

        $configService = ConfigurationService::create(getcwd() . "/../app/config.json");
        $databaseConfig = $configService->get('database');
        $databaseService = DatabaseServiceFactory::create($databaseConfig);
        $databaseRepositoryService = new DatabaseRepositoryLoaderService($databaseService);

        $serviceRepository->registerService('config', $configService);
        $serviceRepository->registerService('router', RouterServiceFactory::create());
        $serviceRepository->registerService('database', $databaseService);
        $serviceRepository->registerService('databaseRepositoryLoader', $databaseRepositoryService);
        $serviceRepository->registerService('session', SessionService::create([]));

        return $serviceRepository;

    }
}