<?php
namespace App\Services;

class CardsService {
    private $repository;

    public function __construct() {
        $this->repository = new \App\Repositories\CardsRepository();
    }

    public function getCardsByBoardId($boardId) {
        return $this->repository->getCardsByBoardId($boardId);
    }

    public function getCardById($cardId) {
        return $this->repository->getCardById($cardId);
    }

    public function addCard($card) {
        return $this->repository->createCard($card);
    }

    public function updateCard($card) {
        return $this->repository->updateCard($card);
    }
}