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
}