<?php
namespace App\Controllers;

require_once __DIR__ . '/../helpers/session_helper.php';

class AccountController
{
    private $accountService;

    function __construct()
    {
        $this->accountService = new \App\Services\AccountService();
    }

    public function index()
    {
        require __DIR__ . '/../views/account/index.php';
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require __DIR__ . '/../views/account/signup.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $this->sanitizePostData();

            if (!$this->validateRegistration($postData)) {
                // Store form data in local storage to repopulate form fields
                echo "<script>";
                echo "var formData = " . json_encode($postData) . ";";
                echo "localStorage.setItem('signupFormData', JSON.stringify(formData));";
                echo "window.location.href = '/account/signup';";
                echo "</script>";
                return;
            }

            // Create user object and populate with sanitized POST data
            $user = new \App\Models\User();
            $user->name = $postData['name'];
            $user->email = $postData['email'];
            $user->username = $postData['username'];
            $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);

            if ($this->accountService->signup($user)) {
                // Clear local storage data after successful signup
                echo '<script>localStorage.removeItem("signupFormData");</script>';

                // Redirect to login page after successful signup and display success message
                flash("register", 'You are registered and can log in.', 'alert alert-success');
                echo '<script>window.location.href = "/account/login";</script>';
            } else {
                flash("register", 'Something went wrong.');
                redirect('/account/signup');
            }
        }
    }

    private function sanitizePostData()
    {
        // Sanitize POST data to prevent XSS attacks and SQL injections. 
        return [
            'name' => trim(htmlspecialchars(filter_input(INPUT_POST, 'name'))),
            'email' => trim(strtolower(htmlspecialchars(filter_input(INPUT_POST, 'email')))),
            'username' => trim(strtolower(htmlspecialchars(filter_input(INPUT_POST, 'username')))),
            'password' => trim(filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW)),
            'confirmPassword' => trim(filter_input(INPUT_POST, 'confirmPassword', FILTER_UNSAFE_RAW)),
        ];
    }

    private function validateRegistration($postData)
    {
        if (
            empty($postData['name']) ||
            empty($postData['email']) ||
            empty($postData['username']) ||
            empty($postData['password']) ||
            empty($postData['confirmPassword'])
        ) {
            flash("register", 'Please fill in all fields.');
            return false;
        }

        if (!preg_match("/^[a-zA-Z0-9]*$/", $postData['username'])) {
            flash("register", 'Username can only contain letters and numbers.');
            return false;
        }

        if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
            flash("register", 'Please enter a valid email.');
            return false;
        }

        if (strlen($postData['password']) < 8 || strlen($postData['password']) > 32) {
            flash("register", 'Password must be between 8 and 32 characters.');
            return false;
        }

        if (!preg_match("/[a-zA-Z0-9!@#$%^&*()_+-=]/", $postData['password'])) {
            flash("register", 'Password can only contain letters, numbers, and special characters.');
            return false;
        }

        if (!preg_match("/[a-z]/", $postData['password'])) {
            flash("register", 'Password must contain at least one lowercase letter.');
            return false;
        }

        if (!preg_match("/[A-Z]/", $postData['password'])) {
            flash("register", 'Password must contain at least one uppercase letter.');
            return false;
        }

        if (!preg_match("/[0-9]/", $postData['password'])) {
            flash("register", 'Password must contain at least one number.');
            return false;
        }

        if (!preg_match("/[!@#$%^&*()_+=-]/", $postData['password'])) {
            flash("register", 'Password must contain at least one special character.');
            return false;
        }

        if ($postData['password'] !== $postData['confirmPassword']) {
            flash("register", 'Passwords do not match.');
            return false;
        }

        if($this->accountService->checkIfEmailOrUsernameExists($postData['email'], $postData['username'])) {
            flash("register", 'Email or username already exists.');
            return false;
        }

        return true;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require __DIR__ . '/../views/account/login.php';
            return;
        }
    }
}