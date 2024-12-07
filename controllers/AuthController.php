<?php
require_once __DIR__ . '/../models/User.php';

class AuthController
{
    public function showLoginForm()
    {
        require "views/login.php";
    }

    public function login()
    {
        $email = trim($_POST['userEmail']);
        $pass = trim($_POST['userPass']);

        if (empty($email) || empty($pass)) {
            $_SESSION['login_error'] = 'empty_fields';
            $this->showLoginForm();
            return;
        }

        $userModel = new User();
        $user = $userModel->getUserByEmail($email);

        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            header("Location: controllers/MenuController.php");
            exit();
        } else {
            $_SESSION['login_error'] = 'invalid_credentials';
            $this->showLoginForm();
        }
    }
}
