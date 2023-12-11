<?php
namespace App\Services;

class AccountService {
    private $repository;

    public function __construct() {
        $this->repository = new \App\Repositories\AccountRepository();
    }

    public function signup($user) {
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        return $this->repository->insert($user);
    }

    public function checkIfEmailOrUsernameExists($email, $username) {
        return $this->repository->emailOrUsernameExists($email, $username);
    }

    public function login($usernameOrEmail, $password) {
        $user = $this->repository->getUserByUsernameOrEmail($usernameOrEmail);

        if (!$user) return false;

        if (!password_verify($password, $user->password)) return false;

        return $user;
    }

    public function changePassword($user, $newPassword) {
        $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        return $this->repository->changePassword($user, $newPassword);
    }
}