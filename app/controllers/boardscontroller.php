<?php
namespace App\Controllers;

require_once __DIR__ . '/../helpers/session_helper.php';

class BoardsController
{
    private $boardsService;

    public function __construct()
    {
        $this->boardsService = new \App\Services\BoardsService();
    }

    public function index()
    {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            if (!isset($_SESSION['user_id'])) {
                redirect('/account/login');
            }

            $boards = $this->boardsService->getBoards($_SESSION['user_id']);
            require __DIR__ . '/../views/boards/index.php';
        }

        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['addboard'])) {
            $postData = $this->sanitizeAddBoardData();

            // create object using postData
            $board = new \App\Models\Board();
            $board->userId = $_SESSION['user_id'];
            $board->name = $postData['boardTitle'];
            $board->description = $postData['boardDescription'];

            $boardId = $this->boardsService->addBoard($board);
            if ($boardId) {
                redirect('/boards/board?id=' . $boardId);
            } else {
                echo '<script>alert("Failed to add board");</script>';
            }
        }
    }

    private function sanitizeAddBoardData()
    {
        // Sanitize POST data to prevent XSS attacks and SQL injections. 
        return [
            'boardTitle' => trim(htmlspecialchars(filter_input(INPUT_POST, 'boardTitle'))),
            'boardDescription' => trim(htmlspecialchars(filter_input(INPUT_POST, 'boardDescription')))
        ];
    }

    public function board()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (!isset($_SESSION['user_id'])) {
                redirect('/account/login');
            }

            $board = $this->boardsService->getBoard($_GET['id']);

            if (!$board || $board->userId != $_SESSION['user_id']) {
                redirect('/boards');
            }

            require __DIR__ . '/../views/boards/board.php';
        }

        // Check if removeboard POST request has been sent and call removeBoard method
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['removeboard'])) $this->removeBoard();
    }

    private function removeBoard()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!isset($_SESSION['user_id'])) {
                redirect('/account/login');
            }

            $boardData = json_decode($_POST['board'], true);

            // Check if board exists and if the user is the owner of the board
            if (!$boardData || $boardData['userId'] != $_SESSION['user_id']) {
                redirect('/boards');
            }

            if ($this->boardsService->removeBoard($boardData['id'])) {
                redirect('/boards');
            } else {
                echo '<script>alert("Failed to remove board");</script>';
            }
        }
    }
}