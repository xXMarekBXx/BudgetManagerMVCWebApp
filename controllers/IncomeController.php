<?php
session_start();
require_once "../connect.php";
require_once "../models/IncomeModel.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location: ../views/login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
$success_message = "";
$error_message = "";

$connection = getDatabaseConnection();
if ($connection->connect_errno) {
    die("Error: " . $connection->connect_errno . " Reason: " . $connection->connect_error);
}

$model = new IncomeModel($connection);
$categories = $model->getIncomeCategories($userId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $categoryId = $_POST['selectCategory'];
    $comment = $_POST['comment'];

    if ($amount > 0 && !empty($date) && !empty($categoryId)) {
        if ($model->addIncome($userId, $categoryId, $amount, $date, $comment)) {
            $success_message = "Income successfully added!";
        } else {
            $error_message = "Failed to add income. Please try again.";
        }
    } else {
        $error_message = "Please fill in all required fields.";
    }
}

$connection->close();
require_once "../views/IncomeView.php";
