<?php
namespace App\Repositories;

use PDO;

class BoardsRepository extends Repository {
    public function checkUserBoardAccess($boardId, $userId) {
        $stmt = $this->connection->prepare("SELECT * FROM boards WHERE id = :boardId AND userId = :userId");
        $stmt->execute([
            'boardId' => $boardId,
            'userId' => $userId
        ]);
        $results = $stmt->fetchAll(PDO::FETCH_CLASS, '\App\Models\Board');
        return count($results) > 0;
    }

    public function createBoard($board) {
        $stmt = $this->connection->prepare("INSERT INTO boards (userId, name, description) 
            VALUES (:userId, :name, :description)");
        
        $results = $stmt->execute([
            'userId' => $board->userId,
            'name' => $board->name,
            'description' => $board->description
        ]);

        if ($results) {
            return $this->connection->lastInsertId();
        } else {
            return false;
        }
    }

    public function getBoardById($boardId) {
        $stmt = $this->connection->prepare("SELECT * FROM boards WHERE id = :boardId");
        $stmt->execute([
            'boardId' => $boardId
        ]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, '\App\Models\Board');
        $board = $stmt->fetch();
        return $board;
    }

    public function getBoardsByUserId($userId) {
        $stmt = $this->connection->prepare("SELECT * FROM boards WHERE userId = :userId");
        $stmt->execute([
            'userId' => $userId
        ]);
        $results = $stmt->fetchAll(PDO::FETCH_CLASS, '\App\Models\Board');
        return $results;
    }

    public function updateBoard($board) {
        $stmt = $this->connection->prepare("UPDATE boards SET name = :name, description = :description WHERE id = :id");
        $results = $stmt->execute([
            'name' => $board->name,
            'description' => $board->description,
            'id' => $board->id
        ]);
        return $results;
    }

    public function deleteBoard($boardId) {
        $stmt = $this->connection->prepare("DELETE FROM boards WHERE id = :id");
        $results = $stmt->execute([
            'id' => $boardId
        ]);
        return $results;
    }
}