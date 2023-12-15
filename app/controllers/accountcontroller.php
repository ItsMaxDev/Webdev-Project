<?php
namespace App\Controllers;

require_once __DIR__ . '/../helpers/session_helper.php';

class AccountController
{
    private $accountService;

    public function __construct()
    {
        $this->accountService = new \App\Services\AccountService();
    }

    public function index()
    {
        require __DIR__ . '/../views/account/index.php';
    }

    public function settings() {
        require __DIR__ . '/../views/account/settings.php';
    }

    public function security() {
        if($_SERVER['REQUEST_METHOD'] == "GET") {
            require __DIR__ . '/../views/account/security.php';
            return;
        }
        
        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['changepassword'])) {
            $this->changepassword();
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require __DIR__ . '/../views/account/login.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $this->sanitizeLoginData();

            if (!$this->validateLogin($postData)) {
                $this->storeFormData($postData, "loginFormData");
                redirect('/account/login');
            }

            // Attempt to login user and redirect to account page if successful
            $user = $this->accountService->login($postData['usernameOrEmail'], $postData['password']);
            if ($user) {
                // Clear local storage data
                echo '<script>localStorage.removeItem("loginFormData");</script>';

                $this->createSession($user);

                redirect('/account');
            } else {
                $this->storeFormData($postData, "loginFormData");
                flash("login", 'Incorrect username/email or password.');
                redirect('/account/login');
            }
        }
    }

    public function logout()
    {
        if (isset($_SESSION['user_id'])) 
        {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_username']);
            session_destroy();
        }
        redirect('/account/login');
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require __DIR__ . '/../views/account/signup.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $this->sanitizeSignupData();

            if (!$this->validateRegistration($postData)) {
                $this->storeFormData($postData, "signupFormData");
                redirect('/account/signup');
            }

            // Create user object and populate with sanitized POST data
            $user = new \App\Models\User();
            $user->name = $postData['name'];
            $user->email = $postData['email'];
            $user->username = $postData['username'];
            $user->password = $postData['password'];

            // Attempt to signup user and redirect to login page if successful
            if ($this->accountService->signup($user)) {
                // Clear local storage data after successful signup
                echo '<script>localStorage.removeItem("signupFormData");</script>';

                flash("login", 'You are registered and can log in.', 'alert alert-success');
                redirect('/account/login');
            } else {
                $this->storeFormData($postData, "signupFormData");
                flash("register", 'Something went wrong.');
                redirect('/account/signup');
            }
        }
    }

    private function storeFormData($postData, $formName)
    {
        echo "<script>";
        echo "var formData = " . json_encode($postData) . ";";
        echo "localStorage.setItem('$formName', JSON.stringify(formData));";
        echo "</script>";
    }

    private function sanitizeLoginData()
    {
        // Sanitize POST data to prevent XSS attacks and SQL injections. 
        return [
            'usernameOrEmail' => strtolower(trim(htmlspecialchars(filter_input(INPUT_POST, 'username/email')))),
            'password' => trim(filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW)),
        ];
    }

    private function sanitizeSignupData()
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

    private function sanitizeChangePasswordData()
    {
        // Sanitize POST data to prevent XSS attacks and SQL injections. 
        return [
            'current_password' => trim(filter_input(INPUT_POST, 'current_password', FILTER_UNSAFE_RAW)),
            'new_password' => trim(filter_input(INPUT_POST, 'new_password', FILTER_UNSAFE_RAW)),
            'confirm_password' => trim(filter_input(INPUT_POST, 'confirm_password', FILTER_UNSAFE_RAW)),
        ];
    }

    private function validateLogin($postData)
    {
        if (empty($postData['usernameOrEmail']) || empty($postData['password'])) {
            flash("login", 'Please fill in all fields.');
            return false;
        }

        if (!$this->accountService->checkIfEmailOrUsernameExists($postData['usernameOrEmail'], $postData['usernameOrEmail'])) {
            flash("login", 'Incorrect username/email or password.');
            return false;
        }

        return true;
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

    private function validateChangePassword($postData)
    {
        if (
            empty($postData['current_password']) ||
            empty($postData['new_password']) ||
            empty($postData['confirm_password'])
        ) {
            flash("security", 'Please fill in all fields.');
            return false;
        }

        if ($postData['new_password'] !== $postData['confirm_password']) {
            flash("security", 'Passwords do not match.');
            return false;
        }

        if ($postData['new_password'] === $postData['current_password']) {
            flash("security", 'New password cannot be the same as current password.');
            return false;
        }

        if (strlen($postData['new_password']) < 8 || strlen($postData['new_password']) > 32) {
            flash("security", 'New password must be between 8 and 32 characters.');
            return false;
        }

        if (!preg_match("/[a-zA-Z0-9!@#$%^&*()_+-=]/", $postData['new_password'])) {
            flash("security", 'New password can only contain letters, numbers, and special characters.');
            return false;
        }

        if (!preg_match("/[a-z]/", $postData['new_password'])) {
            flash("security", 'New password must contain at least one lowercase letter.');
            return false;
        }

        if (!preg_match("/[A-Z]/", $postData['new_password'])) {
            flash("security", 'New password must contain at least one uppercase letter.');
            return false;
        }

        if (!preg_match("/[0-9]/", $postData['new_password'])) {
            flash("security", 'New password must contain at least one number.');
            return false;
        }

        if (!preg_match("/[!@#$%^&*()_+=-]/", $postData['new_password'])) {
            flash("security", 'New password must contain at least one special character.');
            return false;
        }

        return true;
    }

    private function createSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_username'] = $user->username;
    }

    private function changepassword()
    {
        $postData = $this->sanitizeChangePasswordData();

        if (!$this->validateChangePassword($postData)) {
            redirect('/account/security');
        }

        $user = $this->accountService->login($_SESSION['user_username'], $postData['current_password']);
        if (!$user) {
            flash("security", 'Incorrect password.');
            redirect('/account/security');
        }

        if ($this->accountService->changePassword($user, $postData['new_password'])) {
            flash("security", 'Password changed successfully.', 'alert alert-success');
            redirect('/account/security');
        } else {
            flash("security", 'Something went wrong.');
            redirect('/account/security');
        }
    }
}