<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header('Location: LogIn.php');
    exit();
}

require_once "../models/ChangeEmailModel.php";

$error_message = $_SESSION['error_message'] ?? '';
$success_message = $_SESSION['success_message'] ?? '';
$currentEmail = null;

try {
    if (isset($_SESSION['user_id'])) {
        $model = new ChangeEmailModel();
        $userId = $_SESSION['user_id'];
        $currentEmail = $model->getCurrentEmail($userId);

        if ($currentEmail === null) {
            $error_message = "Unable to retrieve the current email.";
        }
    } else {
        $error_message = "User not logged in.";
    }
} catch (Exception $e) {
    $error_message = 'Error occurred: ' . $e->getMessage();
}

unset($_SESSION['error_message']);
unset($_SESSION['success_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Change Email</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
</head>

<body>

    <main>

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <?php
                    if (!empty($error_message)) {
                        echo '<p style="color: red;">' . htmlspecialchars($error_message) . '</p>';
                    }
                    if (!empty($success_message)) {
                        echo '<p style="color: green;">' . htmlspecialchars($success_message) . '</p>';
                    }
                    ?>
                    <h2>Change Email for User: <?php echo htmlspecialchars($_SESSION['user_id']); ?>
                        <?php
                        if ($currentEmail !== null) {
                            echo "(Current Email: " . htmlspecialchars($currentEmail) . ")";
                        } else {
                            echo "(Current Email: Not Found)";
                        }
                        ?>
                    </h2>
                </div>

                <div class="col-sm-12 col-md-12">
                    <form action="../controllers/ChangeEmailController.php" method="post">
                        <p>
                            <label for="newEmail">New Email:</label>
                            <input id="newEmail" type="email" name="newEmail" placeholder="Enter new email" required
                                style="width: 100%; max-width: 350px; padding: 10px; font-size: 16px; border-radius: 5px;">
                        </p>
                        <p>
                            <button type="submit" class="button">Submit Change</button>
                        </p>
                    </form>
                </div>

                <div class="col-sm-12 col-md-12">
                    <button class="buttonStyle">
                        <a href="../views/SettingsView.php" type="button" class="button">Back to Settings</a>
                    </button>
                </div>
            </div>