<?php

namespace ZBurgermeiszter\PWManager\DatabaseRepositories;

use ZBurgermeiszter\App\Abstracts\AbstractDatabaseRepository;
use ZBurgermeiszter\PWManager\DataStructures\User;

class UsersRepository extends AbstractDatabaseRepository
{

    public function getUser($username, $password)
    {

        $sql = "
                SELECT `id`, `username`, `password`
                FROM `users`
                WHERE username = ?
                AND password = ?
                AND active = 1
                LIMIT 1
        ";

        $userRecord = $this->execAndFetch($sql, [$username, $password]);

        if (!$userRecord) {
            return false;
        }

        return new User($userRecord['id'], $userRecord['username'], $userRecord['password']);
    }

}