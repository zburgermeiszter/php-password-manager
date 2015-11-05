<?php

namespace ZBurgermeiszter\App\Services;

class ServiceRepository
{
    private $services;

    public function registerService($serviceName, $service)
    {
        $this->services[$serviceName] = $service;
    }

    public function getService($serviceName)
    {
        if (!array_key_exists($serviceName, $this->services)) {
            throw new \Exception("Invalid service name ($serviceName)");
        }
        return $this->services[$serviceName];
    }
}