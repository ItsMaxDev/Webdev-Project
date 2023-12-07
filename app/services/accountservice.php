<?php
namespace App\Services;

class AccountService {
    public function signup($user) {
        $repository = new \App\Repositories\AccountRepository();
        return $repository->insert($user);
    }

    public function checkIfEmailOrUsernameExists($email, $username) {
        $repository = new \App\Repositories\AccountRepository();
        return $repository->emailOrUsernameExists($email, $username);
    }

    public function login($usernameOrEmail, $password) {
        $repository = new \App\Repositories\AccountRepository();
        $user = $repository->getUserByUsernameOrEmail($usernameOrEmail);

        if (!$user) return false;

        if (!password_verify($password, $user->password)) return false;

        return $user;
    }
}