<?php

namespace ZBurgermeiszter\App\Factories;

class DatabaseServiceFactory
{
    public static function create($databaseConfig)
    {
        $requiredConfigFields = ['type', 'host', 'port', 'database', 'charset', 'username', 'password'];

        foreach ($requiredConfigFields as $requiredField) {
            if (!array_key_exists($requiredField, $databaseConfig)) {
                throw new \Exception("Missing database config field: $requiredField");
            }
        }

        $dsnTemplate = "%s:host=%s;port=%d;dbname=%s;charset=%s";
        $dsnValues = [];
        foreach ($requiredConfigFields as $configFieldName) {
            $dsnValues[] = $databaseConfig[$configFieldName];
        }
        $dsn = vsprintf($dsnTemplate, $dsnValues);


        return new \PDO($dsn, $databaseConfig['username'], $databaseConfig['password']);
    }
}