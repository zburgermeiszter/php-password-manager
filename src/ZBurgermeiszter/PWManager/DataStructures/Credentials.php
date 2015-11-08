<?php

namespace ZBurgermeiszter\PWManager\DataStructures;

class Credentials implements \JsonSerializable
{
    private $id;
    private $site;
    private $username;
    private $password;

    public function __construct(array $credentialsArray)
    {
        foreach ($credentialsArray as $itemName => $itemContent) {
            if (property_exists($this, $itemName)) {
                $this->{$itemName} = $itemContent;
            }
        }
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'site' => $this->site,
            'username' => $this->username,
            'password' => $this->password
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }


}