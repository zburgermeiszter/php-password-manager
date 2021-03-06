<?php

namespace ZBurgermeiszter\App\Services;

class ConfigurationService
{
    private $config;

    public function __construct($configJSONPath)
    {
        $this->config = json_decode(file_get_contents($configJSONPath), true);
    }

    public static function create($configJSONPath)
    {
        return new static($configJSONPath);
    }

    public function get($itemName)
    {
        if (!array_key_exists($itemName, $this->config)) {
            return null;
        }

        return $this->config[$itemName];
    }

}