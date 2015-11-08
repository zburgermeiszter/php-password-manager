<?php

namespace ZBurgermeiszter\PWManager\DatabaseRepositories;

use ZBurgermeiszter\App\Abstracts\AbstractDatabaseRepository;
use ZBurgermeiszter\PWManager\DataStructures\User;

class CredentialsRepository extends AbstractDatabaseRepository
{
    public function listCredentials(User $user)
    {
        $sql = "SELECT `id`, `site`, `username`, `password`
                FROM `credentials`
                WHERE `user` = ?";

        return $this->execAndFetchAll($sql, [$user]);
    }
}