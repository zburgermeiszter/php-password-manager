<?php

namespace ZBurgermeiszter\App\Interfaces;

use ZBurgermeiszter\App\Services\DatabaseService;

interface DatabaseRepositoryInterface
{
    function __construct(DatabaseService $databaseService);
}