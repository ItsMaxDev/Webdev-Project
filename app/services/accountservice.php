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
}