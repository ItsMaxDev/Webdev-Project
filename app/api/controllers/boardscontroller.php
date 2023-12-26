<?php
namespace App\Api\Controllers;

require_once __DIR__ . '/../../helpers/session_helper.php';

class BoardsController
{
    private $boardsService;

    public function __construct()
    {
        $this->boardsService = new \App\Services\BoardsService();
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $boards = $this->boardsService->getBoards($_SESSION['user_id']);
            echo json_encode($boards);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {            
            $json = file_get_contents('php://input');
            $boardData = json_decode($json, true);

            if ($boardData && isset($boardData['addboard'])) {
                if (!isset($boardData['boardTitle'], $boardData['boardDescription'])) {
                    http_response_code(400);
                    echo json_encode(['message' => 'Missing board data']);
                    return;
                }

                $postData = $this->sanitizeAddBoardData($boardData);

                $board = new \App\Models\Board();
                $board->userId = $_SESSION['user_id'];
                $board->name = $postData['boardTitle'];
                $board->description = $postData['boardDescription'];

                $boardId = $this->boardsService->addBoard($board);
                if ($boardId) {
                    echo json_encode(['message' => 'Board added successfully', 'boardId' => $boardId]);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to add board']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid JSON data']);
            }
        }
    }

    private function sanitizeAddBoardData($data)
    {
        return [
            'boardTitle' => trim(htmlspecialchars($data['boardTitle'])),
            'boardDescription' => trim(htmlspecialchars($data['boardDescription']))
        ];
    }
}