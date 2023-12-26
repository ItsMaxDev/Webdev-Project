<?php
namespace App\Services;

class BoardsService {
    private $repository;

    public function __construct() {
        $this->repository = new \App\Repositories\BoardsRepository();
    }

    public function checkUserBoardAccess($boardId, $userId) {
        return $this->repository->checkUserBoardAccess($boardId, $userId);
    }

    public function addBoard($board) {
        return $this->repository->createBoard($board);
    }

    public function getBoard($boardId) {
        return $this->repository->getBoardById($boardId);
    }

    public function getBoards($userId) {
        return $this->repository->getBoardsByUserId($userId);
    }

    public function editBoard($board) {
        return $this->repository->updateBoard($board);
    }

    public function removeBoard($boardId) {
        return $this->repository->deleteBoard($boardId);
    }
}