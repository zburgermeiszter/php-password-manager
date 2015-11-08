<?php

namespace ZBurgermeiszter\PWManager\DatabaseRepositories;

use ZBurgermeiszter\App\Abstracts\AbstractDatabaseRepository;
use ZBurgermeiszter\PWManager\DataStructures\User;

class UsersRepository extends AbstractDatabaseRepository
{
    public function createSession($username, $password, \DateTime $validUntil)
    {
        $user = $this->getUser($username, $password);

        if (!$user) {
            return [];
        }

        $token = $this->insertSessionForUser($user, $validUntil);

        if (!$token) {
            return [];
        }

        return [
            'token' => $token,
            'valid_until' => $validUntil->format('c')
        ];

    }

    public function getUserByToken($token)
    {
        $sql = "SELECT users.* FROM `sessions`
                RIGHT JOIN users ON sessions.user = users.id
                WHERE sessions.token = ?
                AND sessions.valid_until >= NOW()
                AND users.active = 1
                LIMIT 1";

        $userRecord = $this->execAndFetch($sql, [$token]);

        if (!$userRecord) {
            return false;
        }

        return new User($userRecord['id'], $userRecord['username']);
    }

    private function insertSessionForUser(User $user, \DateTime $validUntil)
    {

        $token = md5(uniqid() . $user . mt_rand());

        $sql = "INSERT INTO `passwordmanager`.`sessions`
                  (`user`, `token`, `valid_until`)
                VALUES
                  (?, ?, ?);";

        $insertSuccess = $this->exec($sql, [$user, $token, $validUntil->format('c')]);

        if (!$insertSuccess) {
            return false;
        }

        return $token;
    }

    public function updateToken($token, \DateTime $validUntil)
    {
        $sql = "UPDATE `sessions`
                SET valid_until = ?
                WHERE `token` = ?";

        return $this->execUpdate($sql, [
            $validUntil->format('c'),
            $token
        ]);

    }

    private function getUser($username, $password)
    {

        $sql = "
                SELECT `id`, `username`
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

        return new User($userRecord['id'], $userRecord['username']);
    }

}