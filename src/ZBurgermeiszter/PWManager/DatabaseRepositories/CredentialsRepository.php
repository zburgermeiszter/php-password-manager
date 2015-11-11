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

    public function getCredential(User $user, $credentialID)
    {
        $sql = "SELECT `id`, `site`, `username`, `password`
                FROM `credentials`
                WHERE `user` = ?
                AND id = ?
                LIMIT 1";

        $credentialArray = $this->execAndFetch($sql, [$user, $credentialID]);

        if (!$credentialArray) {
            return false;
        }

        return new Credentials($credentialArray);
    }

    public function updateCredentials(User $user, Credentials $credentials)
    {
        $sql = "UPDATE `credentials`
                SET
                `site` = ?,
                `username` = ?,
                `password` = ?
                WHERE
                `credentials`.`id` = ?
                AND `user` = ?;
                ";

        return $this->execUpdate($sql, [
            $credentials->getSite(),
            $credentials->getUsername(),
            $credentials->getPassword(),
            $credentials->getId(),
            $user->getId()
        ]);

    }

}