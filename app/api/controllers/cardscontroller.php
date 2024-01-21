<?php
namespace App\Api\Controllers;

class CardsController
{
    private $cardsService;
    private $boardsService;

    public function __construct()
    {
        $this->cardsService = new \App\Services\CardsService();
        $this->boardsService = new \App\Services\BoardsService();
    }

    public function index() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
                return;
            }

            if (isset($_GET['boardId'])) {
                $userId = $_SESSION['user_id'];
                $boardId = $_GET['boardId'];
                
                // Check if the board belongs to the user
                if (!$this->boardsService->checkUserBoardAccess($boardId, $userId)) {
                    http_response_code(403);
                    echo json_encode(['message' => 'Forbidden']);
                    return;
                }
                
                $cards = $this->cardsService->getCardsByBoardId($boardId);
                
                echo json_encode($cards);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing data']);
            }
        }
    }

    public function card() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode(['message' => 'Unauthorized']);
                return;
            }

            if (isset($_GET['boardId'], $_GET['cardId'])) {
                $userId = $_SESSION['user_id'];
                $boardId = $_GET['boardId'];
                $cardId = $_GET['cardId'];
            
                // Check if the board belongs to the user
                if (!$this->boardsService->checkUserBoardAccess($boardId, $userId)) {
                    http_response_code(403);
                    echo json_encode(['message' => 'Forbidden']);
                    return;
                }
                
                $card = $this->cardsService->getCardById($cardId);
                if ($card)
                    echo json_encode($card);
                else {
                    http_response_code(404);
                    echo json_encode(['message' => 'Card not found']);
                }
            
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing data']);
            }
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
            $data = json_decode($json, true);

            if ($data && isset($data['boardId'], $data['listId'], $data['cardName'], $data['cardDescription'])) {
                $boardId = filter_var($data['boardId'], FILTER_SANITIZE_NUMBER_INT);
                $listId = filter_var($data['listId'], FILTER_SANITIZE_NUMBER_INT);
                $cardName = trim(htmlspecialchars($data['cardName']));
                $cardDescription = trim(htmlspecialchars($data['cardDescription']));
                $cardDueDate = isset($data['cardDueDate']) ? filter_var($data['cardDueDate'], FILTER_SANITIZE_STRING) : null;

                // Check if the board belongs to the user
                if (!$this->boardsService->checkUserBoardAccess($boardId, $userId)) {
                    http_response_code(403);
                    echo json_encode(['message' => 'Forbidden']);
                    return;
                }

                $card = new \App\Models\Card();
                $card->listId = $listId;
                $card->name = $cardName;
                $card->description = $cardDescription;
                $card->dueDate = $cardDueDate;

                $cardId = $this->cardsService->addCard($card);
                if ($cardId) {
                    echo json_encode(['message' => 'Card added successfully', 'cardId' => $cardId]);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to add card']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing data']);
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
            $data = json_decode($json, true);
            
            if ($data && isset($data['boardId'], $data['cardId'], $data['cardName'], $data['cardDescription'])) {
                $boardId = filter_var($data['boardId'], FILTER_SANITIZE_NUMBER_INT);
                $cardId = filter_var($data['cardId'], FILTER_SANITIZE_NUMBER_INT);
                $cardName = trim(htmlspecialchars($data['cardName']));
                $cardDescription = trim(htmlspecialchars($data['cardDescription']));
                $cardDueDate = isset($data['cardDueDate']) ? filter_var($data['cardDueDate'], FILTER_SANITIZE_STRING) : null;

                // Check if the board belongs to the user
                if (!$this->boardsService->checkUserBoardAccess($boardId, $userId)) {
                    http_response_code(403);
                    echo json_encode(['message' => 'Forbidden']);
                    return;
                }

                $card = new \App\Models\Card();
                $card->id = $cardId;
                $card->name = $cardName;
                $card->description = $cardDescription;
                $card->dueDate = $cardDueDate;

                $result = $this->cardsService->updateCard($card);
                if ($result) {
                    echo json_encode(['message' => 'Card updated successfully']);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to update card']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing data']);
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
            $data = json_decode($json, true);
            
            if ($data && isset($data['boardId'], $data['cardId'])) {
                $boardId = filter_var($data['boardId'], FILTER_SANITIZE_NUMBER_INT);
                $cardId = filter_var($data['cardId'], FILTER_SANITIZE_NUMBER_INT);

                // Check if the board belongs to the user
                if (!$this->boardsService->checkUserBoardAccess($boardId, $userId)) {
                    http_response_code(403);
                    echo json_encode(['message' => 'Forbidden']);
                    return;
                }

                $result = $this->cardsService->deleteCard($cardId);
                if ($result) {
                    echo json_encode(['message' => 'Card deleted successfully']);
                } else {
                    http_response_code(500);
                    echo json_encode(['message' => 'Failed to delete card']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Missing data']);
            }
        }
    }
}