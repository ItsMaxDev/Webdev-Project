<?php
namespace App\Services;

class ListsService {
    private $repository;

    public function __construct() {
        $this->repository = new \App\Repositories\ListsRepository();
    }

    public function getListsByBoardId($boardId) {
        return $this->repository->getListsByBoardId($boardId);
    }

    public function addList($list) {
        return $this->repository->createList($list);
    }

    public function updateList($list) {
        return $this->repository->updateList($list);
    }

    public function deleteList($listId) {
        return $this->repository->deleteList($listId);
    }
}