<?php

namespace ZBurgermeiszter\PWManager\DataStructures;

class User
{
    private $id;
    private $userName;
    private $password;

    public function __construct($id, $userName, $password)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->password = $password;
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

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

}