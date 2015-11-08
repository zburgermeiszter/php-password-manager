<?php

namespace ZBurgermeiszter\PWManager\DataStructures;

class User
{
    private $id;
    private $userName;

    public function __construct($id, $userName)
    {
        $this->id = $id;
        $this->userName = $userName;
    }

    public function __toString()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

}