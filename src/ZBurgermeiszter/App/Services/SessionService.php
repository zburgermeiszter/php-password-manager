<?php

namespace ZBurgermeiszter\App\Services;

class SessionService
{
    private $session = [];

    public function __construct($initialSessionContent = [])
    {
        $this->session = $initialSessionContent;
    }

    public static function create($initialSessionContent)
    {
        return new static($initialSessionContent);
    }

    public function get($itemName)
    {
        if (!array_key_exists($itemName, $this->session)) {
            return null;
        }

        return $this->session[$itemName];
    }

    public function set($itemName, $itemContent)
    {
        $this->session[$itemName] = $itemContent;
    }

}