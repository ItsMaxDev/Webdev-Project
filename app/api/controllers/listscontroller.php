<?php
namespace App\Api\Controllers;

class ListsController
{
    private $listsService;
    private $boardsService;

    public function __construct()
    {
        $this->listsService = new \App\Services\ListsService();
        $this->boardsService = new \App\Services\BoardsService();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $userId = $_SESSION['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['boardId'])) {
            $boardId = filter_var($_GET['boardId'], FILTER_SANITIZE_NUMBER_INT);
            
            // Check if the board belongs to the user
            if (!$this->boardsService->checkUserBoardAccess($boardId, $userId)) {
                http_response_code(403);
                echo json_encode(['message' => 'Forbidden']);
                return;
            }
            
            $lists = $this->listsService->getListsByBoardId($boardId);

            echo json_encode($lists);
        }
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $userId = $_SESSION['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json = file_get_contents('php://input');
            $listData = json_decode($json, true);

            if ($listData && isset($listData['boardId'], $listData['listName'])) {
                $boardId = filter_var($listData['boardId'], FILTER_SANITIZE_NUMBER_INT);
                $listName = trim(htmlspecialchars($listData['listName']));

                // Check if the board belongs to the user
                if (!$this->boardsService->checkUserBoardAccess($boardId, $userId)) {
                    http_response_code(403);
                    echo json_encode(['message' => 'Forbidden']);
                    return;
                }

                $list = new \App\Models\BoardList();
                $list->boardId = $boardId;
                $list->name = $listName;

                $listId = $this->listsService->addList($list);
                if ($listId) {
                    echo json_encode(['message' => 'List added successfully', 'listId' => $listId]);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to add list']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing list data']);
            }
        }
    }

    public function update() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $userId = $_SESSION['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "PUT") {
            $json = file_get_contents('php://input');
            $listData = json_decode($json, true);

            if ($listData && isset($listData['boardId'], $listData['listId'], $listData['listName'])) {
                $boardId = filter_var($listData['boardId'], FILTER_SANITIZE_NUMBER_INT);
                $listId = filter_var($listData['listId'], FILTER_SANITIZE_NUMBER_INT);
                $listName = trim(htmlspecialchars($listData['listName']));

                // Check if the board belongs to the user
                if (!$this->boardsService->checkUserBoardAccess($boardId, $userId)) {
                    http_response_code(403);
                    echo json_encode(['message' => 'Forbidden']);
                    return;
                }

                $list = new \App\Models\BoardList();
                $list->id = $listId;
                $list->name = $listName;

                $result = $this->listsService->updateList($list);
                if ($result) {
                    echo json_encode(['message' => 'List updated successfully']);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to update list']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing list data']);
            }
        }
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $userId = $_SESSION['user_id'];

        if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $json = file_get_contents('php://input');
            $listData = json_decode($json, true);

            if ($listData && isset($listData['boardId'], $listData['listId'])) {
                $boardId = filter_var($listData['boardId'], FILTER_SANITIZE_NUMBER_INT);
                $listId = filter_var($listData['listId'], FILTER_SANITIZE_NUMBER_INT);

                // Check if the board belongs to the user
                if (!$this->boardsService->checkUserBoardAccess($boardId, $userId)) {
                    http_response_code(403);
                    echo json_encode(['message' => 'Forbidden']);
                    return;
                }

                $result = $this->listsService->deleteList($listId);
                if ($result) {
                    echo json_encode(['message' => 'List deleted successfully']);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to delete list']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing list data']);
            }
        }
    }
}