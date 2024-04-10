<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="login-styles.css" rel="Stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Login | Manila RBI</title>
</head>
<body class="body1">
    <div class="box">
        <div class="header-image"></div>
        <h1>Registry of Barangay Inhabitants</h1>
        <hr style="width: 350px; margin-top: -8px; margin-bottom: 18px; background-color: #05050550; height: 1px;">
        <form action="process_login.php" method="post">
            <label class="input-label">
                <span class="login__icon fas fa-user"></span>
                <input type="text" name="username" placeholder="  Username" required>
            </label><br>
            <label class="input-label" style="margin-top: -10px; margin-bottom: 10px;">
                <span class="login__icon fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="  Password" required>
                <span class="password-toggle-icon"><i class="fas fa-eye-slash"></i></span>
            </label>
            <script>
                const passwordField = document.getElementById("password");
                const togglePassword = document.querySelector(".password-toggle-icon i");

                togglePassword.addEventListener("click", function () {
                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        togglePassword.classList.remove("fa-eye-slash");
                        togglePassword.classList.add("fa-eye");
                    } else {
                        passwordField.type = "password";
                        togglePassword.classList.remove("fa-eye");
                        togglePassword.classList.add("fa-eye-slash");
                    }
                });
            </script>
            <div class="forgot-password mt-5">
                <a href="forgot-pass.php" draggable="false">Forgot Password?</a>
            </div><br>
            <button type="submit">LOGIN</button>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger mt-5" style="margin-top: 20px; margin-bottom: -5px; background-color: #b31515; color: white; padding: 5px; border-radius: 10px;" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
