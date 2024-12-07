<?php
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: login.php');
    exit();
}

error_log('Session data: ' . print_r($_SESSION, true));

if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $userId = $_SESSION['user_id'];
} else {
    $username = 'Unknown User';
    $userId = 'N/A';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Menu</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
</head>

<body>
    <main>
        <div class="col-sm-12 col-md-12">
            <h4 style="color: gray;">Menu for User: <?php echo htmlspecialchars($username); ?> (ID: <?php echo htmlspecialchars($userId); ?>)</h4>
        </div>

        <h2 class="gradient-text">Choose one of the options:</h2>

        <p>
            <button class="buttonStyle">
                <a href="../views/IncomeView.php" type="button" class="button">Add Income</a>
            </button>
        </p>
        <p>
            <button class="buttonStyle">
                <a href="../views/ExpensesView.php" type="button" class="button">Add Expense</a>
            </button>
        </p>
        <p>
            <button class="buttonStyle">
                <a href="../views/BalanceSheetView.php" type="button" class="button">View the balance sheet</a>
            </button>
        </p>
        <p>
            <button class="buttonStyle">
                <a href="../views/SettingsView.php" type="button" class="button">Settings</a>
            </button>
        </p>
        <p>
            <button class="buttonStyle">
                <a href="../index.php" type="button" class="button">Log Out</a>
            </button>
        </p>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>