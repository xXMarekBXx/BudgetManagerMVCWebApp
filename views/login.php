<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Log In</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
</head>

<body>
    <main>
        <h1>Log In</h1>
        <h2 class="gradient-text">If you already have an account, log in here</h2>

        <?php if (isset($_SESSION['login_error'])): ?>
            <p style="color: red;">
                <?= $_SESSION['login_error'] === 'empty_fields' ? 'All fields are required.' : 'Incorrect credentials! Please try again.'; ?>
            </p>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>

        <form action="../index.php" method="post">
            <div class="form-group" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                <label for="userEmail" style="color: yellowgreen; margin-right: 10px; min-width: 100px; text-align: right;">Email:</label>
                <input id="userEmail" type="email" placeholder="Email" name="userEmail" required
                    oninvalid="this.setCustomValidity('Please enter a valid email address. The email must contain @ and a domain (e.g., example@domain.com).')"
                    oninput="setCustomValidity('')"
                    style="width: 100%; max-width: 350px; padding: 10px; font-size: 16px; border-radius: 5px;">
            </div>
            <div class="form-group" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                <label for="userPass" style="color: yellowgreen; margin-right: 10px; min-width: 100px; text-align: right;">Password:</label>
                <input id="userPass" type="password" placeholder="Password" name="userPass" required
                    oninvalid="this.setCustomValidity('Please enter your password. The password must be at least 8 characters long and contain both letters and numbers.')"
                    oninput="setCustomValidity('')"
                    style="width: 100%; max-width: 350px; padding: 10px; font-size: 16px; border-radius: 5px;">
            </div>
            <button class="button buttonStyle" type="submit" style="width: 100%; border: 2px solid white; padding: 10px; font-size: 23px; color: lightskyblue; background: #111; border-radius: 10px;">Log In</button>
        </form>

        <h2 class="gradient-text">If not, register here</h2>
        <p>
            <button class="buttonStyle">
                <a href="../views/RegistrationView.php" class="button">Back to Registration</a>
            </button>
        </p>
    </main>
</body>

</html>