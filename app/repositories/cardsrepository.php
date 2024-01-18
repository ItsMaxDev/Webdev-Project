<?php
namespace App\Repositories;

use PDO;

class CardsRepository extends Repository {
    public function getCardsByBoardId($boardId) {
        $stmt = $this->connection->prepare("SELECT c.* FROM cards c JOIN lists l ON c.listId = l.id WHERE l.boardId = :boardId");
        $stmt->execute([
            'boardId' => $boardId
        ]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, '\App\Models\Card');
    }

    public function getCardById($cardId) {
        $stmt = $this->connection->prepare("SELECT * FROM cards WHERE id = :cardId");
        $stmt->execute([
            'cardId' => $cardId
        ]);
        return $stmt->fetchObject('\App\Models\Card');
    }

    public function createCard($card) {
        $stmt = $this->connection->prepare("INSERT INTO cards (listId, name, description, dueDate) VALUES (:listId, :name, :description, :dueDate)");
        $stmt->execute([
            'listId' => $card->listId,
            'name' => $card->name,
            'description' => $card->description,
            'dueDate' => $card->dueDate
        ]);
        return $this->connection->lastInsertId();
    }
}