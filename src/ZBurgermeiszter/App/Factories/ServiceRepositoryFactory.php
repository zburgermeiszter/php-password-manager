<?php

namespace ZBurgermeiszter\App\Factories;

use ZBurgermeiszter\App\Services\ConfigurationService;
use ZBurgermeiszter\App\Services\ServiceRepository;

class ServiceRepositoryFactory
{
    public static function create()
    {
        $self = new static;
        $serviceRepository = new ServiceRepository();

        $serviceRepository->registerService('config', $self->createConfigService());
        $serviceRepository->registerService('router', RouterServiceFactory::create());

        return $serviceRepository;

    }

    private function createConfigService()
    {
        $configPath = getcwd() . "/../app/config.json";
        return new ConfigurationService($configPath);
    }
}