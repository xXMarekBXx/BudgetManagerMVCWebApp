<?php
require_once "../models/UserModel.php";

function validatePassword($password)
{
    return preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d\S]{8,}$/', $password);
}

session_start();

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name'], $_POST['email'], $_POST['pass'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['pass'];

        if (!validatePassword($password)) {
            $errorMessage = 'Password must be at least 8 characters long and include both letters and numbers.';
        } else {
            $userModel = new UserModel();

            if ($userModel->userExists($name, $email)) {
                $errorMessage = 'Username or email already exists.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $newUserId = $userModel->registerUser($name, $email, $hashedPassword);
                $userModel->assignDefaultCategories($newUserId);

                header("Location: ../index.php");
                exit();
            }
        }
    }
}

require_once "../views/RegistrationView.php";
