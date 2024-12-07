<?php
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
    exit();
}

require_once "../connect.php";
require_once "../models/ExpensesModel.php";

$connection = getDatabaseConnection();
if ($connection->connect_errno) {
    die("Error: " . $connection->connect_errno . " Reason: " . $connection->connect_error);
}

$model = new ExpensesModel($connection);

if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $userId = $_SESSION['user_id'];
    $categories = $model->getCategories($userId);
    $paymentMethods = $model->getPaymentMethods($userId);
} else {
    $username = 'Unknown User';
    $userId = 'N/A';
    $categories = [];
    $paymentMethods = [];
}

if (empty($categories)) {
    $categories = [['id' => '', 'name' => 'No categories available']];
}

if (empty($paymentMethods)) {
    $paymentMethods = [['id' => '', 'name' => 'No payment methods available']];
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Add Expense</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <style>
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            justify-content: center;
        }

        .form-group label {
            width: 150px;
            margin-right: 10px;
            text-align: right;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 250px;
            padding: 5px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <main class="form-container">
        <h4 style="color: gray;">Expenses User: <?= htmlspecialchars($username); ?> (ID: <?= htmlspecialchars($userId); ?>)</h4>

        <h1>Add Expense</h1>

        <?php if (isset($_SESSION['success_message'])): ?>
            <p style="color: green;"><?= htmlspecialchars($_SESSION['success_message']); ?></p>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <p style="color: red;"><?= htmlspecialchars($_SESSION['error_message']); ?></p>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form action="../controllers/ExpensesController.php" method="post" novalidate>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input id="amount" type="number" placeholder="Amount" name="amount" step="0.01" min="0" required>
            </div>

            <div class="form-group">
                <label for="date">Enter the Expenses date:</label>
                <input id="date" type="date" name="date" value="<?= date('Y-m-d'); ?>" min="2000-01-01" required>
            </div>

            <div class="form-group">
                <label for="selectItem">Select Category:</label>
                <select name="selectItem" id="selectItem" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']); ?>"><?= htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="selectPaymentMethod">Select Payment Method:</label>
                <select name="selectPaymentMethod" id="selectPaymentMethod" required>
                    <?php foreach ($paymentMethods as $method): ?>
                        <option value="<?= htmlspecialchars($method['id']); ?>"><?= htmlspecialchars($method['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" rows="4" cols="50" placeholder="Optional comment"></textarea>
            </div>

            <button type="submit" class="button">Add</button>
            <a href="../views/MenuView.php" class="button">Back to Menu</a>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>