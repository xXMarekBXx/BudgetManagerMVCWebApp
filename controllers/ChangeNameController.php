<?php
session_start();
require_once '../models/ChangeNameModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['newUsername']);
    $userId = $_SESSION['user_id'];

    if (!empty($newUsername)) {
        $model = new ChangeNameModel();
        $model->changeUsername($userId, $newUsername);

        $_SESSION['username'] = $newUsername;
        header("Location: ../views/ChangeNameView.php?success=1");
    } else {
        header('Location: ../views/ChangeNameView.php?error=1');
    }
}
