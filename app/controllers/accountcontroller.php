<?php
namespace App\Controllers;

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

            // Attempt to login user and redirect to account page if successful
            $user = $this->accountService->login($postData['usernameOrEmail'], $postData['password']);
            if ($user) {
                $this->createSession($user);
                header('Location: /account');
            } else {
                $error = 'Incorrect username/email or password.';
                $savedUsernameEmailInput = $postData['usernameOrEmail'];
                require __DIR__ . '/../views/account/login.php';
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
        header('Location: /account/login');
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            require __DIR__ . '/../views/account/signup.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $postData = $this->sanitizeSignupData();

            try {
                $this->validateRegistration($postData);
            } catch (\App\Exceptions\SignupException $e) {
                $error = $e->getMessage();
                $savedNameInput = $postData['name'];
                $savedEmailInput = $postData['email'];
                $savedUsernameInput = $postData['username'];
                require __DIR__ . '/../views/account/signup.php';
                return;
            }

            // Create user object and populate with sanitized POST data
            $user = new \App\Models\User();
            $user->name = $postData['name'];
            $user->email = $postData['email'];
            $user->username = $postData['username'];
            $user->password = $postData['password'];

            // Attempt to signup user and redirect to login page if successful
            if ($this->accountService->signup($user)) {
                header('Location: /account/login');
            } else {
                $error = 'Something went wrong.';
                require __DIR__ . '/../views/account/signup.php';
            }
        }
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

    private function validateRegistration($postData)
    {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $postData['username']))
            throw new \App\Exceptions\SignupException('Username can only contain letters and numbers.');

        if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL))
            throw new \App\Exceptions\SignupException('Please enter a valid email.');

        if (strlen($postData['password']) < 8 || strlen($postData['password']) > 32)
            throw new \App\Exceptions\SignupException('Password must be between 8 and 32 characters.');

        if (!preg_match("/[a-zA-Z0-9!@#$%^&*()_+-=]/", $postData['password']))
            throw new \App\Exceptions\SignupException('Password can only contain letters, numbers, and special characters.');

        if (!preg_match("/[a-z]/", $postData['password']))
            throw new \App\Exceptions\SignupException('Password must contain at least one lowercase letter.');

        if (!preg_match("/[A-Z]/", $postData['password']))
            throw new \App\Exceptions\SignupException('Password must contain at least one uppercase letter.');

        if (!preg_match("/[0-9]/", $postData['password']))
            throw new \App\Exceptions\SignupException('Password must contain at least one number.');

        if (!preg_match("/[!@#$%^&*()_+=-]/", $postData['password']))
            throw new \App\Exceptions\SignupException('Password must contain at least one special character.');

        if ($postData['password'] !== $postData['confirmPassword'])
            throw new \App\Exceptions\SignupException('Passwords do not match.');

        if($this->accountService->checkIfEmailOrUsernameExists($postData['email'], $postData['username']))
            throw new \App\Exceptions\SignupException('Email or username already exists.');
    }

    private function validateChangePassword($postData)
    {
        if ($postData['new_password'] !== $postData['confirm_password'])
            throw new \App\Exceptions\ChangePasswordException('Passwords do not match.');

        if ($postData['new_password'] === $postData['current_password'])
            throw new \App\Exceptions\ChangePasswordException('New password cannot be the same as current password.');

        if (strlen($postData['new_password']) < 8 || strlen($postData['new_password']) > 32)
            throw new \App\Exceptions\ChangePasswordException('New password must be between 8 and 32 characters.');

        if (!preg_match("/[a-zA-Z0-9!@#$%^&*()_+-=]/", $postData['new_password']))
            throw new \App\Exceptions\ChangePasswordException('New password can only contain letters, numbers, and special characters.');

        if (!preg_match("/[a-z]/", $postData['new_password']))
            throw new \App\Exceptions\ChangePasswordException('New password must contain at least one lowercase letter.');

        if (!preg_match("/[A-Z]/", $postData['new_password']))
            throw new \App\Exceptions\ChangePasswordException('New password must contain at least one uppercase letter.');

        if (!preg_match("/[0-9]/", $postData['new_password']))
            throw new \App\Exceptions\ChangePasswordException('New password must contain at least one number.');

        if (!preg_match("/[!@#$%^&*()_+=-]/", $postData['new_password']))
            throw new \App\Exceptions\ChangePasswordException('New password must contain at least one special character.');
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

        try {
            $this->validateChangePassword($postData);
        } catch (\App\Exceptions\ChangePasswordException $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../views/account/security.php';
            return;
        }

        $user = $this->accountService->login($_SESSION['user_username'], $postData['current_password']);
        if (!$user) {
            $error = 'Incorrect password.';
            require __DIR__ . '/../views/account/security.php';
            return;
        }

        if ($this->accountService->changePassword($user, $postData['new_password'])) {
            $success = 'Password changed successfully.';
        } else {
            $error = 'Something went wrong.';
        }
        require __DIR__ . '/../views/account/security.php';
    }
}