<?php
namespace App\Repositories;

use PDO;

class ListsRepository extends Repository {
    public function getListsByBoardId($boardId) {
        $stmt = $this->connection->prepare("SELECT * FROM lists WHERE boardId = :boardId");
        $stmt->execute([
            'boardId' => $boardId
        ]);
        $results = $stmt->fetchAll(PDO::FETCH_CLASS, '\App\Models\BoardList');
        return $results;
    }

    public function createList($list) {
        $stmt = $this->connection->prepare("INSERT INTO lists (boardId, name) VALUES (:boardId, :name)");
        $stmt->execute([
            'boardId' => $list->boardId,
            'name' => $list->name
        ]);
        return $this->connection->lastInsertId();
    }
}