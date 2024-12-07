<?php
require_once __DIR__ . '/../models/ChangePassModel.php';

class ChangePassController
{
    private $model;

    public function __construct()
    {
        $this->model = new ChangePassModel();
    }

    public function handleRequest()
    {
        session_start();
        if (!isset($_SESSION['loggedin'])) {
            header('Location: LogIn.php');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $error_message = null;
        $success_message = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = trim($_POST['currentPassword']);
            $newPassword = trim($_POST['newPassword']);
            $confirmPassword = trim($_POST['confirmPassword']);

            if ($newPassword !== $confirmPassword) {
                $error_message = "New passwords do not match.";
            } else {
                $hashedPassword = $this->model->getCurrentPasswordHash($userId);

                if (password_verify($currentPassword, $hashedPassword)) {
                    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    if ($this->model->updatePassword($userId, $newHashedPassword)) {
                        $success_message = "Password successfully updated!";
                    } else {
                        $error_message = "An error occurred while updating the password.";
                    }
                } else {
                    $error_message = "Current password is incorrect.";
                }
            }
        }

        $this->model->closeConnection();
        require __DIR__ . '/../views/ChangePassView.php';
    }
}

$controller = new ChangePassController();
$controller->handleRequest();
