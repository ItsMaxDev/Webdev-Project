<?php
namespace App\Api\Controllers;

require_once __DIR__ . '/../../helpers/session_helper.php';

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
            $boardId = $_GET['boardId'];
            
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
                $boardId = $listData['boardId'];
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
}