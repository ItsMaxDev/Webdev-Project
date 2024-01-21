<?php
namespace App\Controllers;

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
                header('Location: /account/login');
                return;
            }

            require __DIR__ . '/../views/boards/index.php';
        }
    }

    public function board()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            if (!isset($_SESSION['user_id'])) {
                header('Location: /account/login');
                return;
            }

            if (!isset($_GET['id'])) {
                header('Location: /boards');
                return;
            }

            $board = $this->boardsService->getBoard(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
            if (!$board || $board->userId != $_SESSION['user_id']) {
                header('Location: /boards');
                return;
            }

            require __DIR__ . '/../views/boards/board.php';
        }

        // Check if removeboard POST request has been sent and call removeBoard method
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['removeboard'])) {
            $this->removeBoard();
        }
    }

    private function removeBoard()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (!isset($_SESSION['user_id'])) {
                header('Location: /account/login');
                return;
            }

            $boardData = json_decode($_POST['board'], true);

            // Check if board exists and if the user is the owner of the board
            if (!$boardData || $boardData['userId'] != $_SESSION['user_id']) {
                header('Location: /boards');
                return;
            }

            if ($this->boardsService->removeBoard(filter_var($boardData['id'], FILTER_SANITIZE_NUMBER_INT))) {
                header('Location: /boards');
            } else {
                echo '<script>alert("Failed to remove board");</script>';
            }
        }
    }
}