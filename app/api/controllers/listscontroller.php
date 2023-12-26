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
}