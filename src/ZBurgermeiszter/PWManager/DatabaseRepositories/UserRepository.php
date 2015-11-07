<?php

namespace ZBurgermeiszter\PWManager\DatabaseRepositories;

use ZBurgermeiszter\App\Abstracts\AbstractDatabaseRepository;

class UserRepository extends AbstractDatabaseRepository
{
    public function createSession($username, $password, \DateTime $valid_until)
    {
        $userRecord = $this->getUser($username, $password);

        if (!$userRecord) {
            return [];
        }

        $token = $this->insertSessionForUser($userRecord['id'], $valid_until);

        if (!$token) {
            return [];
        }

        return [
            'token' => $token,
            'valid_until' => $valid_until->format('c')
        ];

    }

    private function insertSessionForUser($user_id, \DateTime $valid_until)
    {

        $token = md5(uniqid() . $user_id . mt_rand());

        $sql = "INSERT INTO `passwordmanager`.`sessions`
                  (`user`, `token`, `valid_until`)
                VALUES
                  (?, ?, ?);";

        $stmt = $this->getDatabaseConnection()->prepare($sql);
        $insertSuccess = $stmt->execute([$user_id, $token, $valid_until->format("Y-m-d H:i:s")]);

        if (!$insertSuccess) {
            return false;
        }

        return $token;
    }

    private function getUser($username, $password)
    {

        $sql = "
                SELECT *
                FROM `users`
                WHERE username = ?
                AND password = ?
                AND active = 1
        ";

        $stmt = $this->getDatabaseConnection()->prepare($sql);
        $stmt->execute([$username, $password]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}