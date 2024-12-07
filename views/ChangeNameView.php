<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: LogIn.php');
    exit();
}

$currentUsername = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown User';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Change Name</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>

<body>

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <h2>Change Name for User: <?php echo htmlspecialchars($currentUsername); ?></h2>

                    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                        <p style="color: green;">Username updated successfully!</p>
                    <?php endif; ?>
                </div>

                <div class="col-sm-12 col-md-12">
                    <form action="../controllers/ChangeNameController.php" method="post">
                        <p>
                            <label for="newUsername">New Name:</label>
                            <input id="newUsername" type="text" name="newUsername" placeholder="Enter new name" required
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
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>