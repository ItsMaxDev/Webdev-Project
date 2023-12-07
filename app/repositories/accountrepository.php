<?php
namespace App\Repositories;

use PDO;

class AccountRepository extends Repository {
    public function emailOrUsernameExists($email, $username) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
        $stmt->execute([
            'email' => $email,
            'username' => $username
        ]);
        $results = $stmt->fetchAll(PDO::FETCH_CLASS, '\App\Models\User');
        return count($results) > 0;
    }

    public function insert($user) {
        $stmt = $this->connection->prepare("INSERT INTO users (name, email, username, password) 
            VALUES (:name, :email, :username, :password)");
        
        $results = $stmt->execute([
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'password' => $user->password
        ]);

        return $results;
    }

    public function getUserByUsernameOrEmail($usernameOrEmail) {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->execute([
            'username' => $usernameOrEmail,
            'email' => $usernameOrEmail
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, '\App\Models\User');
        $user = $stmt->fetch();
        return $user;
    }
}