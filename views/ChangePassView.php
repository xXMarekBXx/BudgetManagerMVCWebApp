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
    <title>Change Password</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
</head>

<body>

    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <h2>Change Password for User: <?php echo htmlspecialchars($userId); ?></h2>
                    <?php
                    if (!empty($error_message)) {
                        echo '<p style="color: red;">' . htmlspecialchars($error_message) . '</p>';
                    }
                    if (!empty($success_message)) {
                        echo '<p style="color: green;">' . htmlspecialchars($success_message) . '</p>';
                    }
                    ?>
                </div>
                <div class="col-sm-12 col-md-12">
                    <form action="../controllers/ChangePassController.php" method="post">
                        <div class="form-group" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <label for="currentPassword" style="color: yellowgreen; margin-right: 12px; min-width: 150px; text-align: right;">Current Password:</label>
                            <input id="currentPassword" type="password" name="currentPassword" placeholder="Enter current password" required
                                oninvalid="this.setCustomValidity('Please enter your current password.')"
                                oninput="setCustomValidity('')"
                                style="width: 100%; max-width: 350px; padding: 10px; font-size: 16px; border-radius: 5px;">
                        </div>
                        <div class="form-group" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <label for="newPassword" style="color: yellowgreen; margin-right: 28px; min-width: 150px; text-align: right;">New Password:</label>
                            <input id="newPassword" type="password" name="newPassword" placeholder="Enter new password" required
                                oninvalid="this.setCustomValidity('Please enter a valid new password. The password must be at least 8 characters long.')"
                                oninput="setCustomValidity('')"
                                style="width: 100%; max-width: 350px; padding: 10px; font-size: 16px; border-radius: 5px;">
                        </div>
                        <div class="form-group" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                            <label for="confirmPassword" style="color: yellowgreen; margin-right: 7px; min-width: 150px; text-align: right;">Confirm Password:</label>
                            <input id="confirmPassword" type="password" name="confirmPassword" placeholder="Confirm new password" required
                                oninvalid="this.setCustomValidity('Please confirm your new password.')"
                                oninput="setCustomValidity('')"
                                style="width: 100%; max-width: 350px; padding: 10px; font-size: 16px; border-radius: 5px;">
                        </div>
                        <button type="submit" class="button" style="width: 100%; border: 2px solid white; padding: 10px; font-size: 23px; color: lightskyblue; background: #111; border-radius: 10px;">Submit Change</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>

</body>

</html>