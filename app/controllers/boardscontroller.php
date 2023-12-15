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
        require __DIR__ . '/../views/boards/index.php';
    }
}