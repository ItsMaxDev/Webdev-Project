<?php
namespace App\Controllers;

class HomeController
{
    private $accountService;

    public function __construct()
    {
        $this->accountService = new \App\Services\AccountService();
    }

    public function index()
    {
        require __DIR__ . '/../views/home/index.php';
    }
}