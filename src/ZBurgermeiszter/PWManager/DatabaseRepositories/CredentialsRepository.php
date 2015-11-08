<?php

namespace ZBurgermeiszter\PWManager\DatabaseRepositories;

use ZBurgermeiszter\App\Abstracts\AbstractDatabaseRepository;
use ZBurgermeiszter\PWManager\DataStructures\Credentials;
use ZBurgermeiszter\PWManager\DataStructures\User;

class CredentialsRepository extends AbstractDatabaseRepository
{
    public function listCredentials(User $user)
    {
        $sql = "SELECT `id`, `site`, `username`, `password`
                FROM `credentials`
                WHERE `user` = ?";

        $credentialsList = $this->execAndFetchAll($sql, [$user]);

        if (!$credentialsList) {
            return $credentialsList;
        }

        $result = [];

        foreach ($credentialsList as $credential) {
            $result[] = new Credentials($credential);
        }

        return $result;
    }

    public function addCredentials(User $user, Credentials $credentials)
    {
        $sql = "INSERT INTO `credentials`
                (`user`, `site`, `username`, `password`)
                VALUES
                (?, ?, ?, ?);";

        return $this->execInsert($sql, [
            $user->getId(),
            $credentials->getSite(),
            $credentials->getUsername(),
            $credentials->getPassword()
        ]);

    }

}