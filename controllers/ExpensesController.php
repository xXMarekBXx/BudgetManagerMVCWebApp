<?php
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
    exit();
}

require_once "../connect.php";

$userId = $_SESSION['user_id'];
$connection = getDatabaseConnection();
if ($connection->connect_errno) {
    die("Connection failed: " . $connection->connect_error);
}

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $date = $_POST['date'];
    $categoryId = $_POST['selectItem'];
    $paymentMethodId = $_POST['selectPaymentMethod'];
    $comment = $_POST['comment'];

    if ($amount > 0 && !empty($date) && !empty($categoryId) && !empty($paymentMethodId)) {
        $stmt = $connection->prepare("INSERT INTO expenses (user_id, expense_category_assigned_to_user_id, payment_method_assigned_to_user_id, amount, date_of_expense, expense_comment) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidss", $userId, $categoryId, $paymentMethodId, $amount, $date, $comment);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Expense successfully added!";
        } else {
            $_SESSION['error_message'] = "Failed to add expense. Please try again.";
        }
        $stmt->close();
    } else {
        $_SESSION['error_message'] = "Please fill in all required fields.";
    }

    header('Location: ../views/ExpensesView.php');
    exit();
}

$connection->close();
