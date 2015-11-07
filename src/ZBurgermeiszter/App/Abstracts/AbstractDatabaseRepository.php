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

}