<?php
session_start();
require_once "../models/ChangeEmailModel.php";

class ChangeEmailController
{
    private $model;

    public function __construct()
    {
        $this->model = new ChangeEmailModel();
    }

    public function handleRequest()
    {
        if (!isset($_SESSION['loggedin'])) {
            header('Location: LogIn.php');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $currentEmail = $_SESSION['email'] ?? $this->model->getCurrentEmail($userId);

        if (empty($_SESSION['email'])) {
            $_SESSION['email'] = $currentEmail;
        }

        $error_message = null;
        $success_message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newEmail = trim($_POST['newEmail']);

            if ($this->model->isEmailTaken($newEmail, $userId)) {
                $error_message = "This email is already in use. Please choose another.";
            } else {
                if ($this->model->updateEmail($newEmail, $userId)) {
                    $_SESSION['email'] = $newEmail;
                    $success_message = "Email successfully updated!";
                } else {
                    $error_message = "An error occurred while updating the email.";
                }
            }
        }

        $_SESSION['error_message'] = $error_message;
        $_SESSION['success_message'] = $success_message;

        header("Location: ../views/ChangeEmailView.php");
        exit();
    }
}

$controller = new ChangeEmailController();
$controller->handleRequest();
