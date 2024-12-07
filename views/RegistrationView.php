<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Registration</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <main>
        <h1 class="gradient-text">Create an Account</h1>
        <h2 class="gradient-text">For registration enter your data below</h2>

        <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>

        <form action="../controllers/RegistrationController.php" method="post">
            <div class="form-group" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                <label for="name" style="color: yellowgreen; margin-right: 10px; min-width: 100px; text-align: right;">Name:</label>
                <input id="name" type="text" name="name" placeholder="Name" required
                    oninvalid="this.setCustomValidity('Please enter your name.')"
                    oninput="setCustomValidity('')"
                    style="width: 100%; max-width: 350px; padding: 10px; font-size: 16px; border-radius: 5px;">
            </div>
            <div class="form-group" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                <label for="email" style="color: yellowgreen; margin-right: 10px; min-width: 100px; text-align: right;">Email:</label>
                <input id="email" type="email" name="email" placeholder="Email" required
                    oninvalid="this.setCustomValidity('Please enter a valid email address. The email must contain @ and a domain (e.g., example@domain.com).')"
                    oninput="setCustomValidity('')"
                    style="width: 100%; max-width: 350px; padding: 10px; font-size: 16px; border-radius: 5px;">
            </div>
            <div class="form-group" style="display: flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                <label for="pass" style="color: yellowgreen; margin-right: 10px; min-width: 100px; text-align: right;">Password:</label>
                <input id="pass" type="password" name="pass" placeholder="Password" required
                    oninvalid="this.setCustomValidity('Please enter a valid password. The password must be at least 8 characters long and include both letters and numbers.')"
                    oninput="setCustomValidity('')"
                    style="width: 100%; max-width: 350px; padding: 10px; font-size: 16px; border-radius: 5px;">
            </div>
            <button type="submit" class="button" style="width: 100%; border: 2px solid white; padding: 10px; font-size: 23px; color: lightskyblue; background: #111; border-radius: 10px;">Register</button>
        </form>

        <h3 class="gradient-text">If you have an account, go to the Login page</h3>
        <p>
            <a href="../index.php" class="button">Go Back</a>
        </p>
    </main>
</body>

</html>