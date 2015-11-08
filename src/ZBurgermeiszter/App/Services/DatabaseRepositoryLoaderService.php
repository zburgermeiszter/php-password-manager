<?php

namespace ZBurgermeiszter\App\Services;

use ZBurgermeiszter\App\Interfaces\DatabaseRepositoryInterface;

class DatabaseRepositoryLoaderService
{
    private $databaseService;

    private $cache = [];

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    /**
     * @param $repositoryAddress
     * @return DatabaseRepositoryInterface
     * @throws \Exception
     */
    public function getRepository($repositoryAddress)
    {

        $repositoryAddressArray = explode(":", $repositoryAddress);

        if (count($repositoryAddressArray) != 3) {
            throw new \Exception("Invalid database repository address: $repositoryAddress");
        }

        list($vendorName, $packageName, $repositoryName) = $repositoryAddressArray;

        $className = $vendorName . '\\' . $packageName . '\\' . 'DatabaseRepositories' . '\\' . $repositoryName . 'Repository';

        if (!class_exists($className)) {
            throw new \Exception("Database repository does not exist: $className");
        }

        if (array_key_exists($className, $this->cache)) {
            return $this->cache[$className];
        }

        $repositoryInstance = new $className($this->databaseService);

        if (!($repositoryInstance instanceof DatabaseRepositoryInterface)) {
            throw new \Exception("Repository should implement DatabaseRepositoryInterface");
        }

        $this->cache[$className] = $repositoryInstance;

        return $this->cache[$className];
    }

}