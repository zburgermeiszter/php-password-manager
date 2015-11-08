<?php

namespace ZBurgermeiszter\App\Abstracts;

use ZBurgermeiszter\App\Interfaces\DatabaseRepositoryInterface;
use ZBurgermeiszter\App\Services\DatabaseService;

abstract class AbstractDatabaseRepository implements DatabaseRepositoryInterface
{

    protected $databaseService;

    public function __construct(DatabaseService $databaseService = null)
    {
        $this->databaseService = $databaseService;
    }

    protected function getDatabaseConnection()
    {
        return $this->databaseService->getConnection();
    }

    protected function execAndFetch($sql, $parameters)
    {
        $stmt = $this->getDatabaseConnection()->prepare($sql);
        $stmt->execute($parameters);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    protected function execAndFetchAll($sql, $parameters)
    {
        $stmt = $this->getDatabaseConnection()->prepare($sql);
        $stmt->execute($parameters);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function exec($sql, $parameters)
    {
        $stmt = $this->getDatabaseConnection()->prepare($sql);
        return $stmt->execute($parameters);
    }

    protected function execInsert($sql, $parameters)
    {
        $connection = $this->getDatabaseConnection();

        $stmt = $connection->prepare($sql);

        $insertSuccess = $stmt->execute($parameters);

        if (!$insertSuccess) {
            return false;
        }

        return $connection->lastInsertId();
    }

    protected function execUpdate($sql, $parameters)
    {
        $connection = $this->getDatabaseConnection();

        $stmt = $connection->prepare($sql);

        $stmt->execute($parameters);

        return $stmt->rowCount();
    }

}