<?php

namespace ZBurgermeiszter\App\Services;

class DatabaseService
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

}